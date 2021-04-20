<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\helpers;

/**
 * Class UrlHelper
 * @package app\helpers
 */
class UrlHelper
{
    /**
     * Remove scheme from URL
     *
     * @param $url
     * @param string $scheme
     * @return string
     */
    public static function removeScheme($url, $scheme = '//')
    {
        $parsed_url = parse_url($url);
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
        $pass     = ($user || $pass) ? "$pass@" : '';
        $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
        return "$scheme$user$pass$host$port$path$query$fragment";
    }

    /**
     * Prepend scheme to URL if it doesn't have it
     *
     * @param $url
     * @param string $scheme
     * @return string
     */
    public static function addScheme($url, $scheme = "http") {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = $scheme . "://" . $url;
        }
        return $url;
    }

    /**
     * Append Query String to URL
     * It accepts query as string or array.
     * Also it handles # in URL and removes the duplicated query strings automatically.
     * Here are the input output
     *
     * $inputsOutputs = [
     *   ['i' => 'http://www.example.com', 'q' => 'q1=1', 'o' => 'http://www.example.com/?q1=1'],
     *   ['i' => 'http://www.example.com', 'q' => 'q1=1&q2=2', 'o' => 'http://www.example.com/?q1=1&q2=2'],
     *   ['i' => 'http://www.example.com/a/', 'q' => 'q1=1', 'o' => 'http://www.example.com/a/?q1=1'],
     *   ['i' => 'http://www.example.com/a.html', 'q' => 'q1=1', 'o' => 'http://www.example.com/a.html?q1=1'],
     *   ['i' => 'http://www.example.com/a/?q2=2', 'q' => 'q1=1', 'o' => 'http://www.example.com/a/?q2=2&q1=1'],
     *   ['i' => 'http://www.example.com/a.html?q2=two', 'q' => 'q1=1', 'o' => 'http://www.example.com/a.html?q2=two&q1=1'],
     *   ['i' => 'http://www.example.com/a.html?q1=1&q2=2', 'q' => 'q1=1', 'o' => 'http://www.example.com/a.html?q1=1&q2=2'],
     *   // overwrite the existing
     *   ['i' => 'http://www.example.com/a.html?q1=1&q2=2', 'q' => 'q1=3', 'o' => 'http://www.example.com/a.html?q1=3&q2=2'],
     *   ['i' => 'http://www.example.com/a/#something', 'q' => 'q1=1', 'o' => 'http://www.example.com/a/#something?q1=1'],
     *   ['i' => 'http://www.example.com/a/?q2=2#soe', 'q' => 'q1=1', 'o' => 'http://www.example.com/a/?q2=2&q1=1#soe'],
     *   ['i' => 'http://www.example.com', 'q' => ['q1' => 1], 'o' => 'http://www.example.com/?q1=1'],
     *   ['i' => 'http://www.example.com', 'q' => ['q1' => 1, 'q2' => 2], 'o' => 'http://www.example.com/?q1=1&q2=2'],
     *   ['i' => 'http://www.example.com/a/', 'q' => ['q1' => 1], 'o' => 'http://www.example.com/a/?q1=1'],
     *   ['i' => 'http://www.example.com/a.html', 'q' => ['q1' => 1], 'o' => 'http://www.example.com/a.html?q1=1'],
     *   ['i' => 'http://www.example.com/a/?q2=2', 'q' => ['q1' => 1], 'o' => 'http://www.example.com/a/?q2=2&q1=1'],
     *   ['i' => 'http://www.example.com/a.html?q2=two', 'q' => ['q1' => 1], 'o' => 'http://www.example.com/a.html?q2=two&q1=1'],
     *   ['i' => 'http://www.example.com/a.html?q1=1&q2=2', 'q' => ['q1' => 1], 'o' => 'http://www.example.com/a.html?q1=1&q2=2'],
     *   ['i' => 'http://www.example.com/a.html?q1=1&q2=2', 'q' => ['q1' => 3], 'o' => 'http://www.example.com/a.html?q1=3&q2=2'],
     *   ['i' => 'http://www.example.com/a/#something', 'q' => ['q1' => 1], 'o' => 'http://www.example.com/a/#something?q1=1'],
     *   ['i' => 'http://www.example.com/a/?q2=2#soe', 'q' => ['q1' => 1], 'o' => 'http://www.example.com/a/?q2=2&q1=1#soe'],
     *   ];
     * @param $url
     * @param $query
     * @return mixed|string
     */
    public static function appendQueryStringToURL($url, $query)
    {
        // If query is empty, return the original url
        if (empty($query)) {
            return $url;
        }

        $parsedUrl = parse_url($url);
        if (empty($parsedUrl['path'])) {
            $url .= '/';
        }

        // if query is an array, convert it to string
        $queryString = is_array($query) ? http_build_query($query) : $query;

        // check if there is already any query string in the URL
        if (empty($parsedUrl['query'])) {
            // remove duplications
            parse_str($queryString, $queryStringArray);
            $url .= '?' . http_build_query($queryStringArray);
        } else {
            $queryString = $parsedUrl['query'] . '&' . $queryString;
            // remove duplications
            parse_str($queryString, $queryStringArray);
            // place the updated query in the original query position
            $url = substr_replace($url, http_build_query($queryStringArray), strpos($url, $parsedUrl['query']), strlen($parsedUrl['query']));
        }

        return $url;
    }
}

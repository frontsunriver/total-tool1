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

use Yii;
use yii\base\InvalidArgumentException;

/**
 * Class Pager
 * @package app\helpers
 *
 * Add basic pagination to a form with page breaks.
 *
 * When a form needs to be rendered in multi steps, Pager can be used to
 * group form components in multiple fieldsets with navigation links (Paginated Form).
 *
 * The paginated form can be manipulated by a javascript, in order to show a
 * multi step form.
 */
class Pager
{

    /**
     * @var string Form html before processing.
     */
    public $data;

    /**
     * @var string Processed Form html. Add a fieldset and navigation links for each "page break" founded.
     */
    protected $paginatedData;
    /**
     * @var array List of html code divided by "page break" tags.
     */
    protected $pages;
    /**
     * @var integer The number of pages.
     */
    protected $numberOfPages;
    /**
     * @var array List of navigation links in html code.
     */
    protected $navigationLinks = array();
    /**
     * @var string Default text of next link.
     */
    protected $next;
    /**
     * @var string Default text of previous link.
     */
    protected $previous;

    /**
     * Constructor.
     *
     * @param null|string $data Html of the form
     */
    public function __construct($data = null)
    {
        // Set default text of navigation links
        $this->next = Yii::t('app', 'Next');
        $this->previous = Yii::t('app', 'Previous');

        if (!is_null($data)) {
            $this->data = $data;
            $this->run();
        }
    }

    /**
     * Set Html of the form
     *
     * @param null|string $data Html of the form
     */
    public function setData($data = null)
    {
        if ($data === null) {
            throw new InvalidArgumentException(Yii::t("app", "The value of data is required."));
        }
        $this->data = $data;
        $this->run();
    }

    /**
     * Get Html of a Page
     *
     * @param int $number
     * @return mixed|null
     */
    public function getPage($number)
    {
        return isset($this->pages[$number]) ? $this->pages[$number] : null;
    }

    /**
     * List of pages
     *
     * @return array List of Html code divided by the "page-break" tag.
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * List of previous pages
     *
     * @param int $to
     * @param int $from
     * @return array List of Html code divided by the "page-break" tag.
     */
    public function getPreviousPages($to, $from = 0)
    {
        return array_slice($this->pages, $from, $to);
    }

    /**
     * @return int Number of Form pages
     */
    public function getNumberOfPages()
    {
        return $this->numberOfPages;
    }

    /**
     * @return string The form processed Html (with fieldsets and navigation links)
     */
    public function getPaginatedData()
    {
        return $this->paginatedData;
    }

    /**
     * Process the form html code,
     * groups form components in fieldsets and add navigation links
     */
    protected function run()
    {
        $this->breakDataInPages();
        $this->addPagination();
    }

    /**
     * Break Form Html code in a code list (pages)
     *
     * Set each page and number of pages
     */
    protected function breakDataInPages()
    {

        if (false !== strpos($this->data, '<div class="page-break"')) {

            // Set navigation links
            $this->loadNavigationLinks($this->data);

            // Set array of pages, each of which is a substring of data
            $this->pages = preg_split(
                '#<div class="page-break" data-button-previous="(.*?)" data-button-next="(.*?)"></div>#s',
                $this->data
            );

            // Set number of pages
            $this->numberOfPages = count($this->pages);

            if ($this->numberOfPages === 1) {
                $this->pages = preg_split(
                    '#<div class="page-break" data-button-next="(.*?)" data-button-previous="(.*?)"></div>#s',
                    $this->data
                );
                // Set number of pages
                $this->numberOfPages = count($this->pages);
            }

        } else {

            // Set array of pages with one page
            $this->pages = array($this->data);

            // Set number of pages
            $this->numberOfPages = 1;

        }

    }

    /**
     * Build a navigation links list in html code, analizing the "page break" tag data
     *
     * @param string $data Text of the form
     */
    protected function loadNavigationLinks($data)
    {

        if (preg_match_all('#data-button-previous="(.*?)" data-button-next="(.*?)"#U', $data, $matches, PREG_SET_ORDER) > 0) {
            foreach ($matches as $match) {
                $previous = !empty($match[1]) ? $match[1] : $this->previous;
                $next = !empty($match[2]) ? $match[2] : $this->next;

                $links = array(
                    "previous" => Html::button($previous, ["class" => "btn btn-primary prev"]),
                    "next" => Html::button($next, ["class" => "btn btn-primary next"]),
                );

                array_push($this->navigationLinks, $links);
            }
        } else if (preg_match_all('#data-button-next="(.*?)" data-button-previous="(.*?)"#U', $data, $matches, PREG_SET_ORDER) > 0) {
            foreach ($matches as $match) {
                $next = !empty($match[1]) ? $match[1] : $this->next;
                $previous = !empty($match[2]) ? $match[2] : $this->previous;

                $links = array(
                    "previous" => Html::button($previous, ["class" => "btn btn-primary prev"]),
                    "next" => Html::button($next, ["class" => "btn btn-primary next"]),
                );

                array_push($this->navigationLinks, $links);
            }
        }

    }

    /**
     * Divide the form in multi step form,
     * adding navigation links and grouping the form components in fieldsets
     */
    protected function addPagination()
    {

        $paginatedData = "";

        if ($this->numberOfPages > 1) { // Only data with multi pages

            // First and last Array index
            $firstPageIndex = 0;
            $lastPageIndex = $this->numberOfPages - 1; // Array index start at 0

            foreach ($this->pages as $currentPageIndex => $currentPage) {
                if ($currentPageIndex === $firstPageIndex) { // First page
                    // Add the content
                    $paginatedData .= $currentPage;
                    // Add links container
                    $paginatedData .= Html::beginTag('div', ['class' => 'form-action col-xs-12']);
                    // Add Next link
                    $paginatedData .= $this->navigationLinks[$currentPageIndex]['next'];
                    // Close links container
                    $paginatedData .= Html::endTag('div');
                    // Close the first fieldset
                    $paginatedData .= Html::endTag('fieldset');
                } elseif ($currentPageIndex === $lastPageIndex) { // Last page
                    // Add previous link to the content, before each submit or image button
                    $pattern = array(
                        '/.button(.*)type=.submit./',
                        '/.input(.*)type=.submit./',
                        '/.input(.*)type=.image./'
                    );
                    $replacement = array(
                        // Show last custom button text
                        $this->navigationLinks[$currentPageIndex-1]['previous'] ." ". '<button$1type="submit"',
                        $this->navigationLinks[$currentPageIndex-1]['previous'] ." ". '<input$1type="submit"',
                        $this->navigationLinks[$currentPageIndex-1]['previous'] ." ". '<input$1type="image"',
                    );
                    $currentPage = preg_replace($pattern, $replacement, $currentPage);
                    // Start the last fieldset
                    $paginatedData .= Html::beginTag('fieldset', ['class' => 'row']);
                    // Add the content
                    $paginatedData .= $currentPage;
                } else { // Mid pages
                    // Start the mid fieldset
                    $paginatedData .= Html::beginTag('fieldset', ['class' => 'row']);
                    // Add the content
                    $paginatedData .= $currentPage;
                    // Add links container
                    $paginatedData .= Html::beginTag('div', ['class' => 'form-action col-xs-12']);
                    // Add Previous link
                    $paginatedData .= $this->navigationLinks[$currentPageIndex-1]['previous'];
                    $paginatedData .= " "; // Fix space
                    // Add Next link
                    $paginatedData .= $this->navigationLinks[$currentPageIndex]['next'];
                    // Close links container
                    $paginatedData .= Html::endTag('div');
                    // Close the mid fieldset
                    $paginatedData .= Html::endTag('fieldset');
                }
            }

        } else {
            // Paginated data is the same raw data
            $paginatedData = $this->data;
        }

        // Set paginatedData
        $this->paginatedData = $paginatedData;

    }
}

<?php

use yii\db\Schema;
use yii\db\Migration;

class m150412_184646_init_theme extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%theme}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_STRING . '(255) NULL',
            'color' => Schema::TYPE_STRING . '(255) NULL',
            'css' => Schema::TYPE_TEXT,
            'created_by' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->insert('{{%theme}}', array(
            "name" => "Blue Denim",
            "description" => "Dark blue body with white big fields.",
            "color" => "#212a3e",
            "css" => '
body {
    background-color: #212a3e;
    padding: 20px;
    color: #7b8291;
}

/* Small devices (tablets, 768px and up) */
@media (min-width: 768px) {
    body {
        padding: 50px;
    }
}
strong {
    color: #FFFFFF;
}
.legend {
    font-family: "helvetica", "arial", "sans-serif";
    font-size: 28px;
    font-weight: 400;
    line-height: 1.4;
    color: #fff;
    margin: 0 0 5px;
}
p.description {
    color: #1ec185;
    background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAsAAAAPCAYAAAAyPTUwAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4JpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NTc3MiwgMjAxNC8wMS8xMy0xOTo0NDowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpEQUIyQTJGOUZCNzZERTExQkFGNUUxNDNCMEI4NkZGMSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFREYxQURBODk5N0YxMUU0OTU0N0EzNkVCREUxQzBFRCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFREYxQURBNzk5N0YxMUU0OTU0N0EzNkVCREUxQzBFRCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxNCAoTWFjaW50b3NoKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOmNlOWNlZGU1LTM1YTYtNDFiNi04NDA4LTM2YmIxMjY4NjdhNSIgc3RSZWY6ZG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOmI2Nzk5MjljLWRmZTMtMTE3Ny1iOGNhLTlmM2YyOWFkM2Y1YiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PoBOvTYAAACrSURBVHjaYpE72MqABKSA2B+IZYH4ERBvAOIXMEkWJIUhQLwIiDmRxHqBOBqqiYEJKiiJpvA/lOaCiosgK/ZFUhgIxKxAHAHl8wKxF7IzZJGs3gCl16L5BW4ystth4A+6AEgRIxBzIIkJYtHICVN8HIjNkSTeYVFcB8QOTGgK8QE7JgYSwCBS/JNItV9BQecJxD5ArAPEikDMB8RsUEM+A/E9IL4EilGAAAMAaCsYB5gwb+gAAAAASUVORK5CYII=") 0 40% no-repeat;
    font-size: 14px;
    padding-left: 20px;
    display: inline-block;
    margin: 5px auto 0;
}
.form-group, .form-action {
    font-size: 14px;
    color: #7b8291;
    margin: 27px 0 9px;
}
.control-label {
    font-size: 16px;
    color: #fff;
    margin: 0 5px 9px 0;
}
.required-control .control-label:after {
    color: #e55;
    margin-left: 5px;
}
.form-control {
    background: #363e51;
    border-color: transparent;
    border-radius: 3px;
    color: #fff;
    margin: 0;
    height: 36px;
    width: 100%;
    -webkit-transition: background .08s linear;
    -moz-transition: background .08s linear;
    -o-transition: background .08s linear;
    transition: background .08s linear;
}
.form-control:hover {
    background: #424a5b
}
.form-control:focus {
    background: #fff;
    color: #212a3e
}
.form-control::-webkit-input-placeholder {
    color: #7b8291
}
.form-control::-moz-placeholder {
    color: #7b8291
}
.form-control:-ms-input-placeholder {
    color: #7b8291
}
.form-control::placeholder {
    color: #7b8291
}
.btn {
    border-radius: 4px;
    border: 0 !important;
    font-size: 18px;
    font-weight: 500;
    width: auto;
    height: 55px;
    line-height: 55px;
    margin: 0;
    padding: 0 30px;
    -webkit-transition: background-color .1s ease;
    -moz-transition: background-color .1s ease;
    -o-transition: background-color .1s ease;
    transition: background-color .1s ease;
}
.btn-primary {
    background-color: #1ec185;
}
.btn-primary:focus, .btn-primary:active, .btn-primary:hover {
    background-color: #1baf79 !important;
    color: #fff;
    border: 0 !important;
    outline: 0 none !important;
    box-shadow: none !important;
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

        $this->insert('{{%theme}}', array(
            "name" => "Sky Blue",
            "description" => "Blue sky background with clouds around. White form with a thin typography.",
            "color" => "#95D6FE",
            "css" => '
@import url(https://fonts.googleapis.com/css?family=Roboto:400,300);
body {
    background-color: #95D6FE;
    overflow-x: hidden;
    padding: 20px;
    color: #A9A9A9;
    color: rgba(255, 255, 255, 0.6);
    font-family: Roboto, sans-serif;
}
/* Small devices (tablets, 768px and up) */
@media (min-width: 768px) {
    body {
        padding: 50px 25%;
    }
}
/**
 * Form
 */
h3 {
    color: #FFFFFF;
    font-size: 32px;
    font-weight: 300;
    text-align: center;
    margin: .3em 0;
    -webkit-animation: titleFadein .8s ease;
    -moz-animation: titleFadein .8s ease;
    animation: titleFadein .8s ease;
}
p:first-of-type {
    color: #FFFFFF;
    color: rgba(255, 255, 255, 0.92);
    font-weight: 300;
    font-size: 20px;
    text-shadow: none;
    text-align: center;
}
.form-group {
    background-color: #ffffff;
    font-size: 14px;
    padding: 20px 40px 10px;
    margin: 0;
}
.form-group:first-of-type {
    padding-top: 40px;
    margin-top: 40px;
    border-radius: 12px 12px 0 0;
}
.form-action {
    margin: 0;
    padding: 20px 40px 40px 40px;
    border-radius: 0 0 12px 12px;
    background-color: #ffffff;
    font-size: 14px;
}
.control-label {
    font-weight: 300;
    font-size: 16px;
    color: #777777;
}
.form-control {
    width: 100%;
    height: 48px;
    -webkit-box-sizing: padding-box;
    -moz-box-sizing: padding-box;
    box-sizing: padding-box;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: #EFEFEF;
    background-color: rgba(0, 0, 0, 0.03);
    border-color: transparent;
    border-radius: 6px;
    font-size: 20px;
    font-family: Roboto, sans-serif;
    font-weight: 300;
    box-shadow: inset 0px 2px 1px rgba(0, 0, 0, .03);
    outline: none;
    text-overflow: ellipsis;
    -webkit-font-smoothing: antialiased;
}
.form-control:focus {
    border-color: rgb(138, 197, 65);
    box-shadow: inset 0 0 0 0,inset 0 1px 2px rgba(138, 197, 65, 0.15),0 0 10px rgba(138, 197, 65, 0.8),0 2px 0 rgba(138, 197, 65,0.1);
    transition: none;
}
.form-control::-webkit-input-placeholder {
    color: #A9A9A9;
}
.form-control::-moz-placeholder {
    color: #A9A9A9;
}
.form-control:-ms-input-placeholder {
    color: #A9A9A9;
}
.form-control::placeholder {
    color: #A9A9A9;
}
.radio label, .checkbox label {
    color: #7C7C7C;
    font-weight: 300;
}
.btn {
    display: block;
    padding: 0 28px;
    border-radius: 28px;
    width: auto;
    height: 56px;
    margin: 0 auto;
    overflow: hidden;
    -webkit-font-smoothing: antialiased;
    font-size: 24px;
}
.btn-primary {
    background-color: rgb(138, 197, 65);
    background-color: rgba(138, 197, 65, 0.90);
    border-color: transparent;
}
.btn-primary:focus, .btn-primary:hover {
    background: rgb(138, 197, 65) !important;
    border-color: transparent !important;
    color: rgb(255, 255, 255) !important;
}
.info {
    font-size: 16px;
    color: rgb(102, 102, 102);
    color: rgba(102, 102, 102, 0.3);
    padding: 10px 40px;
    background-color: #ffffff;
    margin: 0;
}
/**
 * Clouds
 *
 * You must add this snippet to your form:
 *
 * <div id="clouds">
 *   <div class="cloud x1"></div>
 *   <div class="cloud x2"></div>
 *   <div class="cloud x3"></div>
 *   <div class="cloud x4"></div>
 *   <div class="cloud x5"></div>
 * </div>
 *
 * Based on http://thecodeplayer.com/walkthrough/pure-css3-animated-clouds-background
 */
#clouds{
    top: 220px;
    padding: 100px 0;
    position: absolute;
    z-index: -1;
}
/*Time to finalise the cloud shape*/
.cloud {
    width: 200px; height: 60px;
    background: #fff;

    border-radius: 200px;
    -moz-border-radius: 200px;
    -webkit-border-radius: 200px;

    position: relative;
}
.cloud:before, .cloud:after {
    content: "";
    position: absolute;
    background: #fff;
    width: 100px; height: 80px;
    top: -15px; left: 10px;

    border-radius: 100px;
    -moz-border-radius: 100px;
    -webkit-border-radius: 100px;

    -webkit-transform: rotate(30deg);
    transform: rotate(30deg);
    -moz-transform: rotate(30deg);
}
.cloud:after {
    width: 120px; height: 120px;
    top: -55px; left: auto; right: 15px;
}
/*Time to animate*/
.x1 {
    -webkit-animation: moveclouds 15s linear infinite;
    -moz-animation: moveclouds 15s linear infinite;
    -o-animation: moveclouds 15s linear infinite;
}
/*variable speed, opacity, and position of clouds for realistic effect*/
.x2 {
    left: 200px;

    -webkit-transform: scale(0.6);
    -moz-transform: scale(0.6);
    transform: scale(0.6);
    opacity: 0.6; /*opacity proportional to the size*/

    /*Speed will also be proportional to the size and opacity*/
    /*More the speed. Less the time in "s" = seconds*/
    -webkit-animation: moveclouds 25s linear infinite;
    -moz-animation: moveclouds 25s linear infinite;
    -o-animation: moveclouds 25s linear infinite;
}
.x3 {
    left: -250px; top: -200px;

    -webkit-transform: scale(0.8);
    -moz-transform: scale(0.8);
    transform: scale(0.8);
    opacity: 0.8; /*opacity proportional to size*/

    -webkit-animation: moveclouds 20s linear infinite;
    -moz-animation: moveclouds 20s linear infinite;
    -o-animation: moveclouds 20s linear infinite;
}
.x4 {
    left: 470px; top: -250px;

    -webkit-transform: scale(0.75);
    -moz-transform: scale(0.75);
    transform: scale(0.75);
    opacity: 0.75; /*opacity proportional to size*/

    -webkit-animation: moveclouds 18s linear infinite;
    -moz-animation: moveclouds 18s linear infinite;
    -o-animation: moveclouds 18s linear infinite;
}
.x5 {
    left: -150px; top: -150px;

    -webkit-transform: scale(0.8);
    -moz-transform: scale(0.8);
    transform: scale(0.8);
    opacity: 0.8; /*opacity proportional to size*/

    -webkit-animation: moveclouds 20s linear infinite;
    -moz-animation: moveclouds 20s linear infinite;
    -o-animation: moveclouds 20s linear infinite;
}
@-webkit-keyframes moveclouds {
    0% {margin-left: 1600px;}
    100% {margin-left: -1600px;}
}
@-moz-keyframes moveclouds {
    0% {margin-left: 1600px;}
    100% {margin-left: -1600px;}
}
@-o-keyframes moveclouds {
    0% {margin-left: 1600px;}
    100% {margin-left: -1600px;}
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

        $this->insert('{{%theme}}', array(
            "name" => "Gray Shadow",
            "description" => "A gray background with a gray form and a bluish green button.",
            "color" => "#eeeeee",
            "css" => '

body {
    background-color: transparent;
    padding: 0;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 14px;
    color: #000;
}
/* Small devices (tablets, 768px and up) */
@media (min-width: 768px) {
    body.app-form {
        padding: 50px 24%;
        background-color: #eeeeee;
    }
}
form {
    border-style: solid;
    background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 1), rgba(242, 242, 242, 1));
    background-image: linear-gradient(top, rgba(255, 255, 255, 1), rgba(242, 242, 242, 1));
    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 1), rgba(242, 242, 242, 1));
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 100% 100%;
    padding: 15px 25px;
    border-radius: 1px;
    box-shadow: 0px 0px 0px 0px rgba(50, 50, 50, 0.75);
    border-width: 4px;
    border-color: rgb(232,232,232);
}
h3 {
    text-align: center;
    color: rgb(89,89,89);
    font-size: 40px;
}
p.description {
    text-align: center;
    color: rgb(51, 51, 51);
    font-size: 17px;
}
p.info {
    color: rgba(107,107,107,1);
    font-size: 12px;
    margin-top: 15px;
}
.form-control {
    height: 100%;
    -webkit-box-sizing: padding-box;
    -moz-box-sizing: padding-box;
    box-sizing: padding-box;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    padding: 15px;
    font-size: 15px;
    line-height: 15px;
    color: #000;
}
.form-control:focus {
    border-color: rgba(117,194,204,1);
    box-shadow: 0 1px 1px rgba(117,194,204,0.75) inset, 0 0 8px rgba(134,215,225,1);
    outline: 0 none;
}
.form-control::-webkit-input-placeholder { color: #a1a1a1; }
.form-control:-moz-placeholder { color: #a1a1a1; }
.form-control::-moz-placeholder { color: #a1a1a1; }
.form-control:-ms-input-placeholder { color: #a1a1a1; }
.btn {
    color: rgba(255,255,255,1);
    font-size: 19px;
    background-image: -webkit-linear-gradient(top, rgba(134,215,225,1), rgba(117,194,204,1));
    padding: 11px;
    border-radius: 0px;
    border: transparent;
    box-shadow: none;
}
.btn:focus, .btn:hover, input.btn:active {
    background-image: -webkit-linear-gradient(bottom, rgba(134,215,225,1), rgba(117,194,204,1));
    color: rgba(255, 255, 255, 1);
    box-shadow: none !important;
    outline: 0 none !important;
    border-color: transparent;
}
.inline-form .form-control {
    display: inline-block;
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

        $this->insert('{{%theme}}', array(
            "name" => "Light Gray",
            "description" => "Light gray form over dark gray body, big fields with a green button.",
            "color" => "#a9a9a9",
            "css" => '
@import url(https://fonts.googleapis.com/css?family=PT+Sans:400);
@import url(https://fonts.googleapis.com/css?family=Oswald:400);
body {
    font-family: "PT Sans", sans-serif;
    padding: 0;
        background-color: #a9a9a9;
}
/* Small devices (tablets, 768px and up) */
@media (min-width: 768px) {
    body {
        padding: 60px 25%;
    }
}
form {
    padding: 35px;
    background-color: #f3f3f3;
    border: 1px solid rgba(0, 0, 0, 0.34);
    -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.1);
    box-shadow: 0 3px 9px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    color: #555 !important;
}
h3, p {
    text-align: center;
    font-size: 16px;
}
h3 {
    margin: 5px;
    padding: 10px 0 0 0;
    font-size: 28px;
    font-family: "Oswald", sans-serif;
    text-shadow: 2px 2px 3px rgba(255,255,255,0.1);
}
p.description {
    padding: 5px 0 24px 0;
}
.note {
    padding: 24px;
    margin: 10px 0;
}
.form-group {
    margin-bottom: 1px;
    position: relative;
}
.form-action {
    margin-top: 25px;
}
.control-label {
    font-size: 16px;
    margin: 15px 0 0 0;
}
.btn {
    padding: 12px 18px;
    width: 100%;
    border: transparent;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    height: 60px;
    font-size: 20px;
    text-shadow: 0 0 #000;
    -webkit-transition: background-color .1s ease;
    transition: background-color .1s ease;
}
.btn-primary {
    background-color: #1ec185;
}
.btn-primary:focus, .btn-primary:active, .btn-primary:hover {
    background-color: #1baf79 !important;
    border-color: transparent;
    color: #fff;
}
.form-control {
    font-size: 16px;
    color: #6f6f6f;
    border: 2px solid #FFFFFF;
    height: 52px;
}
.form-control:focus {
    border: 2px solid rgb(30, 193, 133);
    border: 2px solid rgba(30, 193, 133, 0.8);
    box-shadow: none;
    outline: 0 none;
}
.form-group-icon:before {
    position: absolute;
    font-family: "Glyphicons Regular";
    font-size: 36px;
    color: darkgray;
    top: 38px;
    left: 10px;
}
.form-group-icon .form-control {
    padding: 15px 12px 12px 52px;
}
.user-icon:before {
    content: "\e004";
}
.email-icon:before {
    content: "\2709";
}
.phone-icon:before {
    content: "\e164";
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

        $this->insert('{{%theme}}', array(
            "name" => "Flower Shop",
            "description" => "Yellow form over Green texture. Orange header and button.",
            "color" => "#FBEFBF",
            "css" => '
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700);

body {
    font-family: "Source Sans Pro", sans-serif;
    font-size: 16px;
    padding: 0;
}
/* Small devices (tablets, 768px and up) */
@media (min-width: 768px) {
    body {
        padding: 50px 25%;
        background: url("../static_files/images/themes/flower-shop.jpg") repeat #AFC86A;
    }
}
form {
    background-color: rgb(251, 239, 191);
    padding-bottom: 50px;
}
/* Small devices (tablets, 768px and up) */
@media (min-width: 768px) {
    form {
        -webkit-box-shadow: 1px 0 11px rgba(50,50,50,0.74);
        -moz-box-shadow: 1px 0 11px rgba(50,50,50,0.74);
        box-shadow: 1px 0 11px rgba(50,50,50,0.74);
    }
}
.legend {
    font-size: 33px;
    margin: 0 0 25px 0;
    padding: 15px 0;
    text-align: center;
    background-color: rgba(251, 89, 39, 0.9);
    color: white;
    font-weight: 700;
    text-shadow: -1px -1px 0 rgba(184, 60, 42, 0.5),
    -2px -2px 1px rgba(184, 60, 42, 0.5);
}
p {
    margin: 0 15%;
}
.form-group, .form-action {
    margin: 0 15%;
}
.form-control {
    height: 42px;
    border: 3px solid rgb(236, 217, 142);
}
.form-control:focus {
    border-color: rgb(253, 186, 144);
    box-shadow: 0 1px 1px rgba(253, 186, 144, 0.75) inset, 0 0 8px rgba(253, 186, 144, 1);
    outline: 0 none;
}
.form-control::-webkit-input-placeholder { color: #313941; color: rgba(49, 57, 65, 0.72); }
.form-control:-moz-placeholder { color: #313941; color: rgba(49, 57, 65, 0.72); }
.form-control::-moz-placeholder { color: #313941; color: rgba(49, 57, 65, 0.72); }
.form-control:-ms-input-placeholder { color: #313941; color: rgba(49, 57, 65, 0.72); }
.control-label {
    font-weight: bold;
    margin-top: 15px;
}
.btn {
    background-color: rgb(251, 89, 39);
    border: transparent;
    width: 100%;
    margin-top: 15px;
    font-size: 22px;
    padding: 8px 0 8px 0;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    text-shadow: -1px -1px 0 rgba(184, 60, 42, 0.5),
    -2px -2px 1px rgba(184, 60, 42, 0.5);
}
.btn:focus, .btn:active, .btn:focus:active {
    outline: none;
    background-color:#f14c26 !important;
    box-shadow: 0 1px 1px rgba(253, 186, 144, 0.75) inset, 0 0 8px rgba(253, 186, 144, 1);
}
.btn:hover{
    background-color:#fe6a48 !important;
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

        $this->insert('{{%theme}}', array(
            "name" => "White Smoke",
            "description" => "Clean design for multiple purposes. Wide fields with a blue button and without shadows.",
            "color" => "#2B8DD6",
            "css" => '
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600);
@import url(https://fonts.googleapis.com/css?family=Raleway:400,600);
body {
    background-color: #fbfcfd;
    padding: 20px;
    font-family: "Open Sans", Helvetica, Arial, sans-serif;
}
.legend {
    font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 20px;
    font-weight: 600;
    color: #515151;
}
.form-control {
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 400;
    height:55px;
	border-radius:3px;
	border-color:#d3d3d3;
}
.form-control:focus {
    border:1px solid #2b8dd6;
    box-shadow: none;
    outline: 0 none;
}
.form-control::-webkit-input-placeholder { color: #797979; }
.form-control:-moz-placeholder { color: #797979; }
.form-control::-moz-placeholder { color: #797979; }
.form-control:-ms-input-placeholder { color: #797979; }
.control-label {
	font-weight: 600;
}
.btn {
    background-color: #2b8dd6;
    box-sizing: border-box !important;
    border: 0 !important;
    border-bottom: 3px solid rgba(0, 0, 0, 0.1) !important;
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 600;
    box-shadow: 0 0 0 !important;
    padding: 16px 32px;
}
.btn:hover, .btn:active, .btn:focus {
    background-color: #2b8dd6;
    opacity:0.85;
	border:0 !important;
	border-bottom:3px solid rgba(0, 0, 0, 0.1) !important;
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

        $this->insert('{{%theme}}', array(
            "name" => "Habitat",
            "description" => "Beauty gradient with a semi-transparent text.",
            "color" => "#1274a3",
            "css" => '
@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700);
@import url(https://fonts.googleapis.com/css?family=Raleway:400,700);
/**
 * Design inspired in https://habitat.inkling.com/signup
 */
body {
    background: linear-gradient(135deg, #1274a3 0%,#68ad74 100%);
    padding: 20px;
    font-family: "Open Sans", Helvetica, Arial, sans-serif;
    color: rgb(255, 255, 255);
    color: rgba(255, 255, 255, 0.75098);
}
.legend {
    font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 26px;
    font-weight: 400;
    color: #FFFFFF;
    color: rgb(255, 255, 255);
}
p, .checkbox-inline, .radio-inline {
    font-weight: 300;
}
.form-control {
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 400;
    transition: box-shadow 150ms ease-in-out;
    background-color: rgb(10,13,25);
    background-color: rgba(10,13,25,0.1);
    border-radius: 3px;
    outline: solid 2px rgba(255,255,255,0);
    border-color: transparent;
    box-shadow: inset 0 1px 1px rgba(10,13,25,0.15),0 1px 0 rgba(255,255,255,0.1);
    box-sizing: border-box;
    font-family: inherit;
    font-size: 16px;
    height: 45px;
    width: 100%;
    color: #FFFFFF;
    color: rgba(255, 255, 255, 0.92098);
}
.form-control:focus {
    box-shadow: inset 0 0 0 1px #fff,inset 0 1px 2px rgba(10,13,25,0.15),0 0 8px rgba(255,255,255,0.5),0 1px 0 rgba(255,255,255,0.1);
    transition: none;
}
.form-control option {
    background-color: #1274a3;
}
.form-control::-webkit-input-placeholder {
    color: #FFFFFF;
    color: rgba(255,255,255,0.35);
}
.form-control:-moz-placeholder {
    color: #FFFFFF;
    color: rgba(255,255,255,0.35);
}
.form-control::-moz-placeholder {
    color: #FFFFFF;
    color: rgba(255,255,255,0.35);
}
.form-control:-ms-input-placeholder {
    color: #FFFFFF;
    color: rgba(255,255,255,0.35);
}
.control-label {
	font-weight: 600;
}
.required-control .control-label:after {
    color: rgb(255, 255, 255) !important;
    color: rgba(255, 255, 255, 0.75098) !important;
}
.btn {
    box-sizing: border-box !important;
    border: 0 !important;
    border-bottom: 3px solid rgba(0, 0, 0, 0.1) !important;
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 600;
    text-shadow: 0 -1px 0 rgba(255,255,255,0.1);
    padding: 16px 32px;
}
.btn-primary {
    background-color: rgb(110,238,215);
    background-color: rgba(110,238,215,0.65);
    box-shadow: inset 0 -2px 0 rgba(0,0,0,0.3),inset 0 1px 0 rgba(255,255,255,0.07),0 1px 1px rgba(10,13,25,0.5);
}
.btn-primary:hover, .btn-primary:active, .btn-primary:focus {
    background-color: rgb(110,238,215) !important;
    background-color: rgba(110,238,215,0.45) !important;
    box-shadow: inset 0 -2px 0 rgba(0,0,0,0.3),inset 0 1px 0 rgba(255,255,255,0.07),0 1px 1px rgba(10,13,25,0.5) !important;
    outline: 0 none !important;
}
/**
 * Alerts
 */
.alert-success {
    background-color: #68ad74;
    border-color: #1274a3;
}
.alert-danger {
    background-color: #ff7332;
    border-color: #1274a3;
}
.has-error .help-block, .has-error .control-label, .has-error .radio, .has-error .checkbox,
.has-error .radio-inline, .has-error .checkbox-inline, .has-error.radio label,
.has-error.checkbox label, .has-error.radio-inline label, .has-error.checkbox-inline label {
    color: #FFFFFF;
}
.has-error .help-block {
    margin: 0;
    padding: 5px 10px;
    color: #FFF;
}
.has-error .form-control {
    border-color: #ff7332;
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

        $this->insert('{{%theme}}', array(
            "name" => "Blue Dress",
            "description" => "A beauty dark theme with subtle shadow, green button and and active fields.",
            "color" => "#374151",
            "css" => '
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600);
@import url(https://fonts.googleapis.com/css?family=Raleway:400,600);
body {
    background-color: #374151;
    padding: 20px;
    font-family: "Open Sans", Helvetica, Arial, sans-serif;
    color: #FBFEFB;
    color: rgba(255, 255, 255, 0.82098);
}
.legend {
    font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 28px;
    font-weight: 400;
    margin-bottom: 25px;
    color: #FBFEFB;
}
.form-control {
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 400;
    transition: box-shadow 150ms ease-in-out;
    background-color: rgba(10,13,25,0.1);
    border-radius: 5px;
    outline: solid 2px rgba(255,255,255,0);
    border: 2px solid transparent;
    box-shadow: inset 0 1px 1px rgba(10,13,25,0.15),0 1px 0 rgba(255,255,255,0.1);
    box-sizing: border-box;
    font-family: inherit;
    font-size: 16px;
    height: 43px;
    width: 100%;
    color: #FFFFFF;
    color: rgba(255, 255, 255, 0.82098);
}
.form-control:focus {
    border:2px solid #95B366;
    box-shadow: none;
    outline: 0 none;
}
.form-control option {
    background-color: #374151;
}
.form-control::-webkit-input-placeholder { color: #4A566A; }
.form-control:-moz-placeholder { color: #4A566A; }
.form-control::-moz-placeholder { color: #4A566A; }
.form-control:-ms-input-placeholder { color: #4A566A; }
.control-label {
    color: #FBFEFB;
	font-weight: 600;
}
.btn {
    box-sizing: border-box !important;
    border: 0 !important;
    border-bottom: 3px solid rgba(0, 0, 0, 0.1) !important;
    font-weight: 600;
    padding: 9px 32px;
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
}
.btn-primary {
    background-color: #95B366;
}
.btn-primary:hover, .btn-primary:active, .btn-primary:focus {
    background-color: #95B366 !important;
    opacity:0.85;
	box-shadow: none;
    outline: 0 none;
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

        $this->insert('{{%theme}}', array(
            "name" => "Tea Time",
            "description" => "Beautiful theme inspired by a cup of tea. With strong contrasts, a transparent black background and white letters, you can see a picture.",
            "color" => "#000000",
            "css" => '
@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700);
@import url(https://fonts.googleapis.com/css?family=Raleway:400,600);
body {
    background-color: transparent;
    background: url("http://demo.easyforms.baluart.com/static_files/images/themes/tea-time.jpg") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    font-family: "Open Sans", Helvetica, Arial, sans-serif;
    color: #FFFFFF;
}
form {
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.75);
    padding: 20px;
}
/* Small devices (tablets, 768px and up) */
@media (min-width: 768px) {
    /* Hide background image of the body in embed view */
    .app-embed {
        background: transparent;
    }
    form {
        padding: 40px;
        border-radius: 10px;
    }
}
.legend {
    font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 28px;
    font-weight: 600;
    margin: 0 0 20px 0;
}
p, .checkbox-inline, .radio-inline {
    font-weight: 300;
}
.form-group, .form-action {
    margin-bottom: 25px;
}
.form-control {
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: #FFFFFF;
    border: 1px solid #FFFFFF;
    background-color: #000000;
    background-color: rgba(0, 0, 0, 0);
    height: 42px;
}
.form-control:focus {
    border-color: #F9690E;
    box-shadow: none;
    outline: 0 none;
    transition: none;
}
.form-control option {
    background-color: #000000;
}
.form-control::-webkit-input-placeholder {
    color: #D2D7D3;
    color: rgba(255,255,255,0.85);
}
.form-control:-moz-placeholder {
    color: #D2D7D3;
    color: rgba(255,255,255,0.65);
}
.form-control::-moz-placeholder {
    color: #D2D7D3;
    color: rgba(255,255,255,0.65);
}
.form-control:-ms-input-placeholder {
    color: #D2D7D3;
    color: rgba(255,255,255,0.65);
}
.control-label {
	font-weight: 600;
}
.btn {
    border-radius: 26px;
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 600;
    padding: 12px 42px;
}
.btn-primary {
    border-color: transparent;
    background-color: #F9690E;
}
.btn-primary:hover, .btn-primary:active, .btn-primary:focus {
    border-color: transparent !important;
    background-color: #fa7d2e !important;
    box-shadow: none !important;
    outline: 0 none !important;
}
/**
 * Alerts
 */
.alert-success {
    background-color: #018930;
    background-color: rgba(1,137,48,0.75);
    border-color: #018930;
}
.alert-danger {
    background-color: #FF0000;
    background-color: rgba(255, 0, 0, 0.75);
    border-color: #FF0000;
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

        $this->insert('{{%theme}}', array(
            "name" => "Purple Bay",
            "description" => "A purple translucent theme with white fields and blue button.",
            "color" => "#2b2c4e",
            "css" => '
@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700);
@import url(https://fonts.googleapis.com/css?family=Raleway:300,400);
body {
    padding: 20px;
    background-color: transparent;
    background: url("http://demo.easyforms.baluart.com/static_files/images/themes/purple-bay.jpg") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    font-family: "Open Sans", Helvetica, Arial, sans-serif;
    color: #cdcdcd;
    color: rgba(255,255,255,0.80);
}
/* Small devices (tablets, 768px and up) */
@media (min-width: 768px) {
    /* Hide background image of the body in embed view */
    .app-embed {
        background: transparent;
        padding: 50px 25%;
    }
}
.legend {
    display: inline-block;
    font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 24px;
    font-weight: 300;
    text-transform: uppercase;
    padding-bottom: 3px;
    border-bottom: 2px solid #1762ee;
    margin: 0 0 20px 0;
    color: #ffffff;
}
/* Small devices (tablets, 768px and up) */
@media (min-width: 768px) {
    .legend {
        font-size: 28px;
    }
}
p {
    font-weight: 300;
}
.form-group, .form-action {
    margin-bottom: 25px;
}
.form-control {
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: #FFFFFF;
    border-color: transparent;
    background-color: #000000;
    background-color: rgba(255, 255, 255, 0.15);
    height: 42px;
}
.form-control:focus {
    border-color: #ffffff;
    border-color: rgba(255, 255, 255, 0.30);
    box-shadow: none;
    outline: 0 none;
    transition: none;
}
.form-control option {
    background-color: #000000;
}
.form-control::-webkit-input-placeholder {
    color: #D2D7D3;
    color: rgba(255,255,255,0.85);
}
.form-control:-moz-placeholder {
    color: #D2D7D3;
    color: rgba(255,255,255,0.65);
}
.form-control::-moz-placeholder {
    color: #D2D7D3;
    color: rgba(255,255,255,0.65);
}
.form-control:-ms-input-placeholder {
    color: #D2D7D3;
    color: rgba(255,255,255,0.65);
}
.control-label, .checkbox-inline, .radio-inline {
    color: #cdcdcd;
    color: rgba(255,255,255,0.80);
	font-weight: 400;
}
.control-label {
	text-transform: uppercase;
}
.btn {
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 600;
    padding: 12px 42px;
}
.btn-primary {
    border-color: transparent;
    background-color: #1762ee;
}
.btn-primary:hover, .btn-primary:active, .btn-primary:focus {
    border-color: transparent !important;
    background-color: #3375f0 !important;
    box-shadow: none !important;
    outline: 0 none !important;
}
/**
 * Alerts
 */
.alert-success {
    background-color: #018930;
    background-color: rgba(1,137,48,0.75);
    border-color: #018930;
}
.alert-danger {
    background-color: #FF0000;
    background-color: rgba(255, 0, 0, 0.75);
    border-color: #FF0000;
}
',
            "created_by" => 1,
            "updated_by" => 1,
            "created_at" => time(),
            "updated_at" => time(),
        ));

    }
    
    public function safeDown()
    {
        // Builds and executes a SQL statement for dropping a DB table.
        $this->dropTable('{{%theme}}');
    }
}

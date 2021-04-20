<?php

use yii\helpers\Html;
use yii\bootstrap\Dropdown;

/* @var $templateItems array */

?>
<?php if (Yii::$app->user->can('createForms')) : ?>
    <div class="btn-group">
        <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create Form'),
            ['create'], ['class' => 'btn btn-primary']) .
        '<button type="button" 
                 class="btn btn-primary dropdown-toggle"
                 data-toggle="dropdown" 
                 aria-haspopup="true" 
                 aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>' .
        Dropdown::widget(['items' => $templateItems])
        ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->user->can('viewThemes', ['listing' => true])): ?>
    <?= Html::a(Yii::t('app', 'Do you want to customize your forms?'), ['/theme'], [
            'data-toggle' => 'tooltip',
            'data-placement'=> 'top',
            'title' => Yii::t('app', 'No problem at all. With a theme, you can easily add custom CSS styles to your forms, to customize colors, field sizes, backgrounds, fonts, and more.'),
            'class' => 'text hidden-xs hidden-sm']
    ) ?>
<?php endif; ?>
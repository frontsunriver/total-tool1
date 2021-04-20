<?php

/* @var $this YiiRequirementChecker */
/* @var $summary array */
/* @var $requirements array[] */

?>

<div class="content">
    <?php if ($summary['errors'] > 0) : ?>
        <div class="alert alert-danger">
            <p class="text-danger">
                <?= Yii::t(
                    'setup',
                    'Unfortunately your server configuration does not satisfy the requirements by this application.'
                )?></p>
            <p class="text-danger">
                <?= Yii::t('setup', 'Please refer to the table below for detailed explanation.')?>
            </p>
        </div>
    <?php elseif ($summary['warnings'] > 0) : ?>
        <p class="text-info">
            <?= Yii::t('setup', 'Your server configuration satisfies the minimum requirements by this application.')?>
        </p>
        <p class="text-info">
            <?= Yii::t(
                'setup',
                'Please pay attention to the warnings listed below and check if your system will use the corresponding features.'
            ) ?>
        </p>
    <?php else : ?>
        <p class="text-success"><span class="glyphicon glyphicon-ok"> </span>
            <?= Yii::t('setup', 'Congratulations! Your server configuration satisfies all requirements.')?>
        </p>
    <?php endif; ?>

    <div id="details">
        <table class="table table-bordered" style="font-size: 0.95em">
            <tr>
                <th><?= Yii::t('setup', 'Name') ?></th>
                <th><?= Yii::t('setup', 'Result') ?></th>
                <th><?= Yii::t('setup', 'Required By') ?></th>
                <th><?= Yii::t('setup', 'Memo')?></th></tr>
            <?php foreach ($requirements as $requirement) : ?>
                <tr class="<?php echo $requirement['condition'] ?
                    'success' : ($requirement['mandatory'] ? 'danger' : 'warning') ?>">
                    <td><?php echo $requirement['name'] ?></td>
                    <td>
                        <span class="result">
                            <?php echo $requirement['condition'] ?
                                Yii::t('setup', 'Passed') : ($requirement['mandatory'] ?
                                    Yii::t('setup', 'Failed') : Yii::t('setup', 'Warning')) ?>
                        </span>
                    </td>
                    <td>
                        <?php echo $requirement['by'] ?>
                    </td>
                    <td>
                        <?php echo $requirement['memo'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>


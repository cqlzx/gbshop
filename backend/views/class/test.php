<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
// throw new Exception('Invalid sort value.');
$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
    <?= $form->field($model, 'username')->textInput()->hint('Please enter your name')->label('Name'); ?>
    <?= $form->field($model, 'password')->checkboxList(['a' => 'Item A', 'b' => 'Item B', 'c' => 'Item C']); ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
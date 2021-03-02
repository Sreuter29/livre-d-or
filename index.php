<?php
require_once 'class/Message.php';
require_once 'class/Guestbook.php';
$errors = null;
$success = false;
$guestBook = new Guestbook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');
if(isset($_POST['username']) && isset($_POST['message'])){
  $message = new Message($_POST['username'], $_POST['message']);
  if($message->isValid()) {
    $guestBook->addMessage($message);
    $success = true;
    $_POST = [];
  } else {
    $errors = $message->getErrors();
  }
}
$messages = $guestBook->getMessages();
$title = "Livre d'or";
require 'elements/header.php';
?>
<div class="container">
  <h1>Livre d'or</h1>
  <?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
      Formulaire invalide
    </div>
  <?php endif ?>
  <?php if(!empty($success)): ?>
    <div class="alert alert-success">
      Merci pour votre message
    </div>
  <?php endif ?>
  <form action="" method="post" class="form">
    <div class="form-group">
      <input type="text" value="<?= htmlentities($_POST['username'] ?? '') ?>" name="username" placeholder="Votre pseudo - 3 caractères minimum" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
      <?php if(isset($errors['username'])): ?>
        <div class="invalid-feedback">
          <?= $errors['username']; ?>
        </div>
      <?php endif ?>
      <textarea name="message" placeholder="Votre message - 10 caractères minimum" class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST["message"] ?? '') ?></textarea>
      <?php if(isset($errors['message'])): ?>
        <div class="invalid-feedback">
          <?= $errors['message']; ?>
        </div>
      <?php endif ?>
    </div>
    <button class="btn btn-primary">Envoyer</button>
  </form>
  <?php if(!empty($messages)):?>
  <h1 class="mt-4">Vos messages</h1>
  <?php foreach ($messages as $message):?>
    <?= $message->toHTML(); ?>
  <?php endforeach ?>
  <?php endif ?>
  <?php
  require 'elements/footer.php';
  ?>
</div>

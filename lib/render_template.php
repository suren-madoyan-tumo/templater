<?php
$title = e($json['title'] ?? 'My Site');
$nav = $json['nav'] ?? ['Home','About','Contact'];
$sections = $json['sections'] ?? [];

?>
<nav class="navbar navbar-dark navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand" href="#"><?= $title ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#n"><span class="navbar-toggler-icon"></span></button>
    <div id="n" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php foreach($nav as $item): ?>
          <li class="nav-item"><a class="nav-link" href="#<?= strtolower(preg_replace('/\s+/','-',$item)) ?>"><?= e($item) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container">
<?php foreach($sections as $s):
  $type = $s['type'] ?? 'section';
  $id   = e($s['id'] ?? strtolower($type));
  $heading = e($s['heading'] ?? ucfirst($type));
?>
  <?php if($type==='hero'): ?>
    <section id="<?= $id ?>" class="py-5 text-center bg-white rounded-4 shadow-sm mb-4">
      <h1 class="display-5 mb-3"><?= $heading ?></h1>
      <?php foreach(($s['paragraphs'] ?? []) as $p): ?>
        <p class="lead"><?= e($p) ?></p>
      <?php endforeach; ?>
      <?php if(!empty($s['cta_text'])): ?>
        <a class="btn btn-primary btn-lg mt-3" href="<?= e($s['cta_link'] ?? '#') ?>"><?= e($s['cta_text']) ?></a>
      <?php endif; ?>
    </section>

  <?php elseif($type==='features'): ?>
    <section id="<?= $id ?>" class="py-5">
      <h2 class="mb-4"><?= $heading ?></h2>
      <div class="row g-3">
        <?php foreach(($s['items'] ?? []) as $feat): ?>
          <div class="col-md-4"><div class="p-3 bg-white border rounded-3 h-100"><?= e($feat) ?></div></div>
        <?php endforeach; ?>
      </div>
    </section>

  <?php elseif($type==='about'): ?>
    <section id="<?= $id ?>" class="py-5">
      <h2 class="mb-3"><?= $heading ?></h2>
      <?php foreach(($s['paragraphs'] ?? []) as $p): ?>
        <p><?= e($p) ?></p>
      <?php endforeach; ?>
    </section>

  <?php elseif($type==='gallery'): ?>
    <section id="<?= $id ?>" class="py-5">
      <h2 class="mb-4"><?= $heading ?></h2>
      <div class="row g-2">
        <?php foreach(($s['items'] ?? []) as $img): ?>
          <div class="col-6 col-md-3"><img class="img-fluid rounded-3" src="<?= e($img) ?>" alt=""></div>
        <?php endforeach; ?>
      </div>
    </section>

  <?php elseif($type==='contact'): ?>
    <section id="<?= $id ?>" class="py-5">
      <h2 class="mb-3"><?= $heading ?></h2>
      <?php foreach(($s['paragraphs'] ?? []) as $p): ?>
        <p><?= e($p) ?></p>
      <?php endforeach; ?>
      <?php if(!empty($s['form'])): ?>
        <form class="row g-2">
          <div class="col-md-6"><input class="form-control" placeholder="Your name"></div>
          <div class="col-md-6"><input class="form-control" placeholder="Email"></div>
          <div class="col-12"><textarea class="form-control" rows="4" placeholder="Message"></textarea></div>
          <div class="col-12"><button class="btn btn-primary">Send</button></div>
        </form>
      <?php endif; ?>
    </section>
  <?php else: ?>
    <section id="<?= $id ?>" class="py-5"><h2><?= $heading ?></h2></section>
  <?php endif; ?>

<?php endforeach; ?>
</main>

<footer class="py-4 text-center text-secondary">
  <small>&copy; <?= date('Y') ?> <?= $title ?> — built with Templater</small>
</footer>

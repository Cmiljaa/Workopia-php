<?= loadPartial('head'); ?>

<?= loadPartial('header'); ?>

<?= loadPartial('top-banner'); ?>

<section>
  <div class="container mx-auto p-4 mt-4"> 
    <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">
      <?php if(isset($keywords)) : ?>
        Search results for: <?= sanitize($keywords) ?>
      <?php else: ?>
        All Jobs
      <?php endif; ?>
    </div>
    <?php loadPartial('message'); ?>
    <?php loadPartial('listings', [ 'listings' => $listings ?? null ]); ?>
  </div>
</section>

<?= loadPartial('bottom-banner'); ?>

<?= loadPartial('footer'); ?>
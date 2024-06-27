<?= loadPartial('head'); ?>

<?= loadPartial('header'); ?>

<?= loadPartial('top-banner'); ?>

<section>
  <div class="container mx-auto p-4 mt-4">
    <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">Error <?= $data['status'] ?></div>
    <p class="text-center text-2xl mb-4">
        <?= $data['message'] ?>
    </p>
    <a class="block p-4 text-blue-700" href="/listings">
      <i class="fa fa-arrow-alt-circle-left"></i>
      Back To Listings
    </a>
  </div>
</section>

<?= loadPartial('footer'); ?>
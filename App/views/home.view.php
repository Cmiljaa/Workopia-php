<?= loadPartial('head'); ?>

<?= loadPartial('header'); ?>

<?= loadPartial('showcase-search'); ?>

<?= loadPartial('top-banner'); ?>

<section>
  <div class="container mx-auto p-4 mt-4"> 
    <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">Recent Jobs</div>
      <?php loadPartial('message'); ?>
      <?php loadPartial('listings', [ 'listings' => $listings ?? null ]); ?>
    </div>
    <a href="/listings" class="block text-xl text-center"> <i class="fa fa-arrow-alt-circle-right"></i> Show All Jobs</a>
  </div> 
</section>

<?= loadPartial('bottom-banner'); ?>

<?= loadPartial('footer'); ?>
<?= loadPartial('head'); ?>

<?= loadPartial('header'); ?>

<?= loadPartial('showcase-search'); ?>

<?= loadPartial('top-banner'); ?>

<section>
  <div class="container mx-auto p-4 mt-4"> 
    <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">Recent Jobs</div>
  


    <a href="/listings" class="block text-xl text-center"> <i class="fa fa-arrow-alt-circle-right"></i> Show All Jobs</a>
  </div>
</section>

<?= loadPartial('bottom-banner'); ?>

<?= loadPartial('footer'); ?>


<!-- Job Listing 2: Marketing Specialist -->
<div class="rounded-lg shadow-md bg-white">
  <div class="p-4">
    <h2 class="text-xl font-semibold">Marketing Specialist</h2>
    <p class="text-gray-700 text-lg mt-2">
      We are looking for a Marketing Specialist to create and manage
      marketing campaigns.
    </p>
    <ul class="my-4 bg-gray-100 p-4 rounded">
      <li class="mb-2"><strong>Salary:</strong> $70,000</li> 
      <li class="mb-2">
        <strong>Location:</strong> San Francisco
        <span class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2">Remote</span> 
      </li>
      <li class="mb-2">  
        <strong>Tags:</strong> <span>Marketing</span>,
        <span>Advertising</span>
      </li>
    </ul>
    <a href="details.html"
    class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
      Details
    </a>
  </div>
</div>
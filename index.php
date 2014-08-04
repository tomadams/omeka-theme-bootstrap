<?php echo head(array('bodyid'=>'home')); ?>

<div class="col-md-1"></div>
<div class="col-md-10">
  <div class="row">

<!--
    <?php if (get_theme_option('Homepage Text')): ?>
    <div class="col-md-4">
      <h2>The Repository</h2>
    <p><?php echo get_theme_option('Homepage Text'); ?></p>
    </div>
    <?php endif; ?>
-->

    <div class="col-md-4">
      <h2>The Repository</h2>
<p>Contains over 380,000 online documents from Nobel laureates' James
D. Watson's and Sydney Brenner's personal collections.
These collections consist of correspondence, manuscripts,
photographs, laboratory notebooks, administrative records,
teaching files & memorabilia.</p>
<p>The repository and metadata were created in part,
through a two-year grant funded collaboration with the
Wellcome Library's Codebreakers: Makers of Modern Genetics
digitization project.</p>
<p>Finding Aids for the majority of the 53 collections on
the history of molecular biology are available on
our <a href="http://library.cshl.edu/archives">CSHL Archives</a> and 
<a href="http://archives.cshl.edu">Digital Collections</a> websites.</p>
</div>

    <div class="col-md-4">
    <?php if (get_theme_option('Display Featured Collection') !== '0'): ?>
    <!-- Featured Collection -->
    <div>
    <?php echo bootstrap_display_featured_collections(); ?>
    </div><!-- end featured collection -->
    <?php endif; ?>
    </div>

    <div class="col-md-4">
      <h2>Features</h2>
<p>Explore all 380,000+ documents of the James D. Watson and
Sydney Brenner  Collections using the
<a href="items/tags">"People & Topics"</a> tagging system,
which consists of over 14,000 tags.</p>
<p>Build your own private selections lists, tags and notes.
Login/register to see this functionality.</p>
<h2>Support</h2>
<p>Scholars are encouraged to <a href="http://library.cshl.edu/archives/contact-the-archives">contact our archivists</a> with research questions, obtaining rights to use materials  or to <a href="http://library.cshl.edu/archives/archive-request-forms">schedule an appointment</a>.
    </div>

  </div>
  <hr /> 
  <div class="row">


    <?php if (get_theme_option('Display Featured Item') !== '0'): ?>
    <!-- Featured Item -->
    <?php echo random_featured_items('4',true); ?>
    <!--end featured-item-->
    <?php endif; ?>


  </div>
 </div>
</div><!-- end secondary -->

<?php echo foot(); ?>

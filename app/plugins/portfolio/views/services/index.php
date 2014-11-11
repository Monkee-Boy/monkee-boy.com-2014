<?php $this->tplDisplay("inc_header.php", ['menu'=>'services']); ?>

  <div class="row">
    <div class="page-title">
      <h1>It's a Jungle Out There on the Web</h1>
      <p class="subtitle">Fortunately, We Have a Three Step Path to Guide Your Way</p>
    </div> <!-- /.page-title -->
  </div> <!-- /.row -->

  <?php foreach($aServices as $aService) { ?>
  <div class="row">
    <div class="panel">
      <aside class="text-center">
        <a href="/our-process/<?php echo $aService['tag']; ?>" title="<?php echo $aService['title']; ?>"><img src="http://www.fillmurray.com/g/436/328" alt=""></a>
      </aside>

      <div class="panel-content">
        <h4><a href="/our-process/<?php echo $aService['tag']; ?>" title="<?php echo $aService['title']; ?>"><?php echo $aService['subtitle']; ?></a></h4>

        <p><?php echo $aService['description']; ?></p>
      </div>
    </div>
  </div> <!-- /.row -->
  <?php } ?>

<?php $this->tplDisplay("inc_footer.php"); ?>

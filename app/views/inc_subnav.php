<div class="row sub-nav">
  <div class="full">
    <?php $this->tplDisplay('subnav/'.$nav.'.php', array('menu'=>$menu, 'from'=>'subnav')); ?>
  </div>
</div>

{footer}
<script>
$(function(){
  $('select[name=select-subnav]').change(function(){
    if($(this).val() != "") {
      location.href = $(this).val();
    }
  });
});
</script>
{/footer}

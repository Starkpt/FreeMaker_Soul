<!-- DESCRIÇÃO INPUT -->
<div class="input-box" id="input-box">
  <textarea class="descricao" name="descricao" rows="4" placeholder="Descrição do produto"></textarea>
</div>

<script>
  $('.descricao').on('input', function() {
    $(this).css('height', 'auto');
    $(this).css('height', this.scrollHeight + 'px');
  });
</script>
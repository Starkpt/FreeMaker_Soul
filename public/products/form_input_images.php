<!-- ADD IMAGES INPUT -->
<div class="input-box" id="product-images">
  <div id="product-images-list"></div>
  <input type="file" id="foto" name="foto[]" accept="image/*" style="display:none;" multiple>
  <button class="img_btn">Inserir Imagens</button>
</div>


<script>
  $('.img_btn').on('click', function(e) {
    e.preventDefault();
    $('#foto').click();
  });

  $('#foto').on('change', function(e) {
    const foto = e.target.files[0];

    for (let i = 0; i < this.files.length; i++) {
      let reader = new FileReader();
      let img_preview = $(`<img class="preview-${i}" />`);

      reader.onload = function(e) {
        img_preview.attr("src", e.target.result);
      }
      reader.readAsDataURL(this.files[i]);
      $('#product-images-list').append(img_preview);
    }

  });
</script>
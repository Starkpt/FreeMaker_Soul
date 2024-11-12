<script>
  $(document).ready(function() {
    $('.stl_btn').on('click', function(e) {
      e.preventDefault();
      $('#ficheiro').click();
    });


    $('#ficheiro').on('change', function() {
      const fileCount = this.files.length;
      const fileCountMsg = $('<p class="file-count"></p>').text(`${fileCount} ficheiros adicionados`);

      // Adiciona a mensagem de contagem ao contêiner
      $('#stl_files').append(fileCountMsg);
    });


    $('.insert_product').on('keydown', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        if (document.activeElement.tagName !== 'BUTTON') {
          $(this).submit();
        }
      }
    });


    function scrollToElement(element, breathe = 0) {
      if (element.length) {
        element[0].focus();
        window.requestAnimationFrame(function() {
          element[0].scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });

          if (breathe) {
            element.addClass('breathing');
            setTimeout(function() {
              element.removeClass('breathing');
            }, 2200);
          }
        });
      }
    }

    if (<?= $_SESSION['adm'] ?>) {
      $('.insert_product').on('submit', function(e) {
        let nome = $('input[name="nome_prod"]');
        let foto = $('#foto');
        let preco = $('input[name="preco"]');
        let categoria = $('select[name="categoria"]');

        if ($.trim(nome.val()) == "") {
          alert("Erro: É necessário introduzir um nome para o produto!");
          e.preventDefault();
          scrollToElement(nome);
          return false;
        }

        if (foto[0].files.length === 0) {
          alert("Erro: Tens que introduzir pelo menos uma foto!");
          e.preventDefault();
          scrollToElement($('.img_btn'), 1);
          return false;
        }

        if ($.trim(preco.val()) == "") {
          alert("Erro: Convém introduzir um preço....");
          scrollToElement(preco);
          e.preventDefault();
          return false;
        }

        if ($.trim(categoria.val()) == "") {
          alert("Erro: Tens que escolher uma categoria!");
          scrollToElement(categoria);
          e.preventDefault();
          return false;
        }
      });

    } else {
      $('.insert_product').on('submit', function(e) {
        let nome = $('input[name="nome_prod"]');
        let categoria = $('select[name="categoria"]');
        let ficheiro = $('#ficheiro');

        if ($.trim(nome.val()) == "") {
          alert("Erro: É necessário introduzir um nome para o produto!");
          scrollToElement(nome);
          e.preventDefault();
          return false;
        }

        if ($.trim(categoria.val()) == "") {
          alert("Erro: É necessário escolher uma categoria!");
          scrollToElement(categoria);
          e.preventDefault();
          return false;
        }

        if (ficheiro[0].files.length === 0) {
          alert("Erro: Tens que introduzir um ficheiro STL!");
          e.preventDefault();
          scrollToElement($('.stl_btn'), 1);
          return false;
        }
      });
    };

  });
</script>
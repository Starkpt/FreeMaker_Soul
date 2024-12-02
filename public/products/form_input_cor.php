<!-- COR INPUT -->
<div class="input-box cor" >
  <select class="cor" id="cor" name="cor[]">
    <option value="">Escolha uma cor</option>
    <?php
    $result = $conn->query('SELECT ID, cor FROM cores');
    while ($row = $result->fetch_assoc()) {
    ?>
      <option name="cor" value="<?= $row['ID'] ?>"> <?= $row['cor'] ?> </option>
    <?php
    }
    ?>
  </select>
</div>
<div id="add_cor" style="display: none;">
  <div class="add_btn">
    <img src="assets/imgs/icons/add.png" alt="Botão de adicionar mais cores" title="Adicionar mais cores">
  </div>
</div>


<script>
  function verificarSelecaoCor() {
    // Verifica se qualquer <select> de cor possui uma seleção válida
    const algumaCor = $('.cor').filter(function() {
      return $(this).val();
    }).length > 0;

    // Exibe o botão se alguma cor estiver selecionada; caso contrário, oculta
    document.getElementById('add_cor').style.display = algumaCor ? 'block' : 'none';
  }

  // Aplica o evento de mudança a todos os selects de cor atuais e futuros
  $(document).on('change', '.cor', verificarSelecaoCor);

  $('#add_cor').on('click', function(e) {
    e.preventDefault();
    verificarSelecaoCor();

    // Cria um novo select de cor
    const newSelectContainer = $('<div class="input-box cor"></div>');
    const newSelect = $('<select class="cor"></select>');

    // Copia as opções do primeiro select 
    $('#cor option').each(function() {
      newSelect.append($(this).clone());
    });

    // Adiciona o novo select ao DOM
    newSelectContainer.append(newSelect);
    $('.input-box.cor').last().after(newSelectContainer);

    verificarSelecaoCor();

    // Oculta o botão "Adicionar cor" logo após criar um novo select
    document.getElementById('add_cor').style.display = 'none';
  });
</script>
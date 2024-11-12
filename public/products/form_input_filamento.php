<!-- FILAMENTO INPUT -->
<div class="input-box fil">
  <select class="filamento" id="filamento" name="filamento[]">
    <option value="">Escolha um tipo de filamento</option>
    <?php
    $result = $conn->query('SELECT ID, tipo FROM filamentos');
    while ($row = $result->fetch_assoc()) {
    ?>
      <option name="filamento" value="<?= $row['ID'] ?>"> <?= $row['tipo'] ?> </option>
    <?php
    }
    ?>
  </select>
</div>
<div class="add_btn_container" id="add_fil" style="display: none;">
  <div class="add_btn">
    <img src="assets/imgs/icons/add.png" alt="Botão de adicionar mais filamentos" title="Adicionar mais filamentos">
  </div>
</div>


<script>
  function verificarSelecaoFilamento() {
    // Verifica se qualquer <select> de filamento possui uma seleção válida
    const algumFilamentoSelecionado = $('.filamento').filter(function() {
      return $(this).val();
    }).length > 0;

    // Exibe o botão se algum filamento estiver selecionado; caso contrário, oculta
    document.getElementById('add_fil').style.display = algumFilamentoSelecionado ? 'block' : 'none';
  }

  // Aplica o evento de mudança a todos os selects de filamento atuais e futuros
  $(document).on('change', '.filamento', verificarSelecaoFilamento);

  $('#add_fil').on('click', function(e) {
    e.preventDefault();
    verificarSelecaoFilamento();

    // Cria um novo select de filamento
    const newSelectContainer = $('<div class="input-box fil"></div>');
    const newSelect = $('<select class="filamento"></select>');

    // Copia as opções do primeiro select 
    $('#filamento option').each(function() {
      newSelect.append($(this).clone());
    });

    // Adiciona o novo select ao DOM
    newSelectContainer.append(newSelect);
    $('.input-box.fil').last().after(newSelectContainer);

    verificarSelecaoFilamento();

    // Oculta o botão "Adicionar Filamento" logo após criar um novo select
    document.getElementById('add_fil').style.display = 'none';
  });
</script>
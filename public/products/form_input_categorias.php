<!-- CATEGORIAS INPUT -->
<div >
  <select name="categoria">
    <option value="">Escolha uma categoria</option>
    <?php
    $result = $conn->query('SELECT ID, c_descricao FROM categorias');
    while ($row = $result->fetch_assoc()) {
    ?>
      <option value="<?= $row['ID'] ?>"><?= $row['c_descricao'] ?></option>
    <?php
    }
    ?>
  </select>
</div>

<script>
</script>
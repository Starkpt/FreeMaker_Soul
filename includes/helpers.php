<?php
function is_logged_in()
{
  return $_SESSION["logged_in"] ?? false;
}

function get_user_id()
{
  return $_SESSION['ID'] ?? null;
}

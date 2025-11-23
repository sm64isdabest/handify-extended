<?php
$displayProducts = array_slice($displayProducts ?? $products, 0, 5);

if (!empty($displayProducts)) {
  foreach ($displayProducts as $p) {
    $img = '';
    if (!empty($p['image'])) {
      if (strpos($p['image'], 'http') === 0 || strpos($p['image'], '/') === 0) {
        $img = $p['image'];
      } else {
        $img = 'uploads/products/' . $p['image'];
      }
    } else {
      $img = 'images/produtos/utensilios/Colher.png';
    }

    $price = isset($p['price']) ? $p['price'] : '';
    if (is_numeric($price)) {
      $price = 'R$ ' . number_format($price, 2, ',', '.');
    }

    $slug = !empty($p['slug']) ? $p['slug'] : (function ($n) {
      $text = preg_replace('~[^\pL\d]+~u', '-', $n);
      $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
      $text = preg_replace('~[^-\w]+~', '', $text);
      $text = trim($text, '-');
      $text = preg_replace('~-+~', '-', $text);
      $text = strtolower($text);
      return $text ?: 'n-a';
    })($p['name'] ?? '');

    echo '<div class="produto" data-id="' . htmlspecialchars($p['id_product'] ?? '') . '" data-slug="' . htmlspecialchars($slug) . '">';
    echo '  <img src="' . htmlspecialchars($img) . '" alt="' . htmlspecialchars($p['name'] ?? '') . '" class="produto-imagem" />';
    echo '  <span class="produto-nome">' . htmlspecialchars($p['name'] ?? '') . '</span>';
    echo '  <div class="produto-preco-bloco">';
    echo '    <div class="produto-preco-desconto-container">';
    echo '      <span class="produto-preco-antigo"></span>';
    echo '      <span class="produto-desconto"></span>';
    echo '    </div>';
    echo '    <span class="produto-preco">' . htmlspecialchars($price) . '</span>';
    echo '  </div>';
    echo '</div>';
  }
} else {
  echo '<p>Nenhum produto cadastrado ainda.</p>';
}
?>
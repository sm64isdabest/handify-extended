console.log("database.js loaded");

// Dados mockados como fallback (mantive apenas um exemplo; complete se quiser)
const mockProducts = [
  {
    name: "Bolsa de Palha Natural Quadrada Artesanal Modelo Grande",
    category: "Bolsa",
    slug: "bolsa-de-palha-natural-quadrada",
    img: "../images/produtos/bolsas/bolsa-flor.png",
    price: "R$280,15",
    originalPrice: "R$294,90",
    discount: 5,
    nota: 4.5,
    avaliacoes: 120,
  }
];

// Normaliza caminho de imagem para ser acessível a partir da página
function normalizeImg(src) {
  if (!src) return '';
  src = String(src).trim();
  // remove prefixos ../ ou ./
  src = src.replace(/^(\.\.\/)+|^(\.\/)+/, '');
  // se já for URL absoluta, retorna
  if (/^https?:\/\//i.test(src)) return src;
  // se caminho começar com '/', usa como absoluto do site
  if (src.charAt(0) === '/') return src;
  // base = pasta atual do documento (ex: /handify-extended)
  const base = window.location.pathname.replace(/\/[^\/]*$/, '');
  return base + '/' + src.replace(/^\/+/, '');
}

function normalizeProductsList(list) {
  return list.map(p => ({
    ...p,
    img: normalizeImg(p.img || ''),
    // opcional: normalize price strings se desejar
  }));
}

// Busca produtos do servidor PHP
async function fetchProducts() {
  try {
    const response = await fetch('?action=get-products');
    if (!response.ok) throw new Error('Erro na resposta do servidor: ' + response.status);
    const data = await response.json();
    const fromServer = Array.isArray(data.products) ? data.products : [];
    const normalized = normalizeProductsList(fromServer);
    console.log('Produtos carregados do banco:', normalized);
    return normalized.length ? normalized : normalizeProductsList(mockProducts);
  } catch (error) {
    console.error('Erro ao buscar produtos do banco, usando mock:', error);
    return normalizeProductsList(mockProducts);
  }
}

export const products = await fetchProducts();
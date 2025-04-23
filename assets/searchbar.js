document.getElementById('search-input').addEventListener('input', function (e) {
  const query = e.target.value.toLowerCase();
  const filters = {
    type: null,
    equipment: [],
    location: null,
  };

  // Détection type
  if (query.includes('hôtel')) filters.type = 'hôtel';
  if (query.includes('auberge')) filters.type = 'auberge';

  // Détection équipement
  const equipments = ['piscine', 'spa', 'wifi', 'parking'];
  equipments.forEach(eq => {
    if (query.includes(eq)) filters.equipment.push(eq);
  });

  // Détection lieu simple (ex: "à Paris", "à Marseille", etc.)
  const regexLocation = /à\s([a-zA-Z\u00C0-\u017F\s]+)/;
  const match = query.match(regexLocation);
  if (match) {
    filters.location = match[1].trim();
  }

  console.log('Filtres extraits :', filters);
  // Tu peux maintenant envoyer ça à ton backend Symfony via fetch ou axios
});

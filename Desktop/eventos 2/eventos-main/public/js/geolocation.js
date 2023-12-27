const locationButton = document.getElementById("get-location");

if ('geolocation' in navigator) {
  const showLocation = async (position) => {
    try {
      const response = await fetch(
        `https://nominatim.openstreetmap.org/reverse?lat=${position.coords.latitude}&lon=${position.coords.longitude}&format=json`
      );
      const data = await response.json();

      const stateAbbreviations = {
        'Acre': 'AC', 'Alagoas': 'AL', 'Amapá': 'AP', 'Amazonas': 'AM', 'Bahia': 'BA',
        'Ceará': 'CE', 'Distrito Federal': 'DF', 'Espírito Santo': 'ES', 'Goiás': 'GO',
        'Maranhão': 'MA', 'Mato Grosso': 'MT', 'Mato Grosso do Sul': 'MS', 'Minas Gerais': 'MG',
        'Pará': 'PA', 'Paraíba': 'PB', 'Paraná': 'PR', 'Pernambuco': 'PE', 'Piauí': 'PI',
        'Rio de Janeiro': 'RJ', 'Rio Grande do Norte': 'RN', 'Rio Grande do Sul': 'RS',
        'Rondônia': 'RO', 'Roraima': 'RR', 'Santa Catarina': 'SC', 'São Paulo': 'SP',
        'Sergipe': 'SE', 'Tocantins': 'TO'
      };

      const uf = stateAbbreviations[data.address.state];
      if (uf) {
        const newSearch = window.location.search.replace(/([?&])s=[^&]*/, `$1s=${uf}`);
        window.location.search = newSearch;
      } else {
        console.error("Estado não mapeado:", data.address.state);
      }
    } catch (error) {
      console.error("Erro ao obter a localização:", error);
    }
  };

  const checkError = (error) => {
    const locationDiv = document.getElementById("location-div");
    switch (error.code) {
      case error.PERMISSION_DENIED:
        locationDiv.innerText = "Por favor, permita que localizemos sua localização!";
        break;
      case error.POSITION_UNAVAILABLE:
        locationDiv.innerText = "Localização inválida!";
        break;
      case error.TIMEOUT:
        locationDiv.innerText = "Localização muito antiga";
        break;
    }
  };

  locationButton.addEventListener("click", () => {
    navigator.geolocation.getCurrentPosition(showLocation, checkError);
  });
} else {
  alert('Ops, não foi possível pegar a localização.');
}

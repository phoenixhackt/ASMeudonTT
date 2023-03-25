// Récupération du formulaire
const form = document.querySelector('#inscription-form');

// Ecouteur d'événements sur la soumission du formulaire
form.addEventListener('submit', (event) => {
  // Empêche l'envoi du formulaire par défaut
  event.preventDefault();

  // Récupération des données du formulaire
  const formData = new FormData(form);

  // Création de l'objet contenant les données
  const data = {};
  formData.forEach((value, key) => {
    data[key] = value;
  });

  // Envoi des données à l'API d'envoi de mails
  const apiUrl = 'https://api.emailjs.com/api/v1.0/email/send';
  const templateParams = {
    from_name: data['nom'] + ' ' + data['prenom'],
    from_email: data['email'],
    message: 'Bonjour, une nouvelle inscription au club de tennis de table Meudon AS est à valider. Voici les informations : Nom : ' + data['nom'] + ', Prénom : ' + data['prenom'] + ', Sexe : ' + data['sexe'] + ', Date de naissance : ' + data['date-naissance'] + ', Nationalité : ' + data['nationalite'] + ', Profession : ' + data['profession'] + ', Adresse : ' + data['adresse'] + ', Code Postal : ' + data['code-postal'] + ', Ville : ' + data['ville'] + ', Tel. Dom : ' + data['tel-dom'] + ', Tel. Port : ' + data['tel-port'] + ', Profession du père : ' + data['profession-pere'] + ', Profession de la mère : ' + data['profession-mere'],
  };
  emailjs.send('YOUR_SERVICE_ID', 'YOUR_TEMPLATE_ID', templateParams, 'YOUR_USER_ID')
    .then((response) => {
      alert('Formulaire envoyé avec succès !');
      form.reset();
    }, (error) => {
      alert('Erreur lors de l\'envoi du formulaire, veuillez réessayer plus tard.');
      console.error(error);
    });
});

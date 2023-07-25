// remove unused link

const linkMap = document.querySelectorAll('.filterLinkMap');

const solutionsRestauration = 'Nos solutions pour la restauration';
const servicesSolutions = 'Services et solutions techniques';
const proximite = 'Hébergement à proximité de nos salles';
const formats = 'Formats de salles';
const eve = 'Événements';
const info = 'info';
const digital = 'Evènement digital';
const efficace = 'Format en U, un aménagement efficace';
const plateaux = "Journées d'études avec plateaux repas & lunch";
const food = 'Traiteur : cocktail et buffet';
const gage = "Le choix du carré, gage de proximité";
const formatReunion = 'Format réunion';
const materielsTechniques = 'Complément matériels techniques';
const escapade = "Hôtels L'Escapade Parisienne ***";
const choix = "Format théâtre : avantages du choix d’une salle multi-usages";
const type = 'Des espaces de location de type classique souvent inadaptés à vos conférences';
const acteurs = 'Des acteurs économiques, associatifs et éducatifs en quête de grandes salles pour un temps limité';
const cabaret = 'Un format cabaret pour des réalités multiples dans vos espaces de réception';
const briser = 'La salle idéale pour briser la glace entre les invités à votre repas';
const outil = 'Format classe : un outil pour votre stratégie éducative';
const groupesT = 'Les formats de type cabaret adéquats pour vos groupes de travail';
const standing = 'Modulabilité, mobilité, standing pour vos cocktails';
const qualifie = 'Personnel technique qualifié';
const cardinal = 'Hôtel Le Cardinal ***';
const foodR = 'Restaurants à proximité';
const disposition = 'Format et disposition des salles';
const auditoriums = "Location d'amphithéâtres et d'auditoriums";
const pauses = "Accueil petit déjeuner et pauses café";
const loc = "Location d'une salle de réception et de cocktail";
const studioMobile = "Nos offres de Studio Mobile";
const offres = "Nos offres";
const conce = "Conceptualisation";
const story = "Notre histoire";
const valeurs = "Concept et valeurs";
const test = "Test"
const studio = "Studio 147"
for(let i =0; i < linkMap.length; i++){
    
        if(  
            linkMap[i].textContent.includes(solutionsRestauration)|| 
            linkMap[i].textContent.includes(servicesSolutions)||
            linkMap[i].textContent.includes(proximite)||
            linkMap[i].textContent.includes(formats)||
            linkMap[i].textContent.includes(eve)||
            linkMap[i].textContent.includes(info)||
            linkMap[i].textContent.includes(digital)||
            linkMap[i].textContent.includes(efficace)||
            linkMap[i].textContent.includes(plateaux)||
            linkMap[i].textContent.includes(food)||
            linkMap[i].textContent.includes(gage)||
            linkMap[i].textContent.includes(formatReunion)||
            linkMap[i].textContent.includes(materielsTechniques)||
            linkMap[i].textContent.includes(escapade)||
            linkMap[i].textContent.includes(choix)||
            linkMap[i].textContent.includes(type)||
            linkMap[i].textContent.includes(acteurs)||
            linkMap[i].textContent.includes(briser)||
            linkMap[i].textContent.includes(outil)||
            linkMap[i].textContent.includes(groupesT)||
            linkMap[i].textContent.includes(standing)||
            linkMap[i].textContent.includes(cardinal)||
            linkMap[i].textContent.includes(qualifie)||
            linkMap[i].textContent.includes(foodR)||
            linkMap[i].textContent.includes(pauses)||
            linkMap[i].textContent.includes(studioMobile)||
            linkMap[i].textContent.includes(disposition)||
            linkMap[i].textContent.includes(loc)||
            linkMap[i].textContent.includes(cabaret)||
            linkMap[i].textContent.includes(valeurs)||
            linkMap[i].textContent.includes(conce)||
            linkMap[i].textContent.includes(offres)||
            linkMap[i].textContent.includes(test)||
            linkMap[i].textContent.includes(story)||
            linkMap[i].textContent.includes(studio)||
            linkMap[i].textContent.includes(auditoriums)){
            
            linkMap[i].remove()
        }
}

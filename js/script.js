async function animalSearch() {
	let requete = document.getElementById("animalSearchBar").value;

	let url;

	if (requete.length === 0) {
		url = "recherche_animal.php";
	} else {
		url = `recherche_animal.php?q=${encodeURIComponent(requete)}`;
	}


	try {
		let response = await fetch(url);
		if (!response.ok) {
			throw new Error("Erreur réseau");
		}

		let data = await response.json(); 
		console.log("Réponse JSON du serveur :", data);

		let resultatSearch = document.getElementById("resultatSearch");
		resultatSearch.innerHTML = ""; 

		if (data.length > 0) {
			data.forEach((animal) => {
				let pName = document.createElement("p");
				let pAge = document.createElement("p");
				let pRace = document.createElement("p");
				let img = document.createElement("img");
				let link = document.createElement("a");

				pName.textContent = `Prénom: ${animal.prenom}`;
				pAge.textContent = `Âge: ${animal.age} ans`;
				pRace.textContent = `Race: ${animal.label}`;
				img.src = `data:image/jpeg;base64,${animal.image_data}`;
				link.href = `detail_animal.php?animal_id=${animal.animal_id}`;
				link.textContent = "Voir la fiche de l'animal";

				resultatSearch.appendChild(pName);
				resultatSearch.appendChild(pAge);
				resultatSearch.appendChild(pRace);
				resultatSearch.appendChild(img);
				resultatSearch.appendChild(link);
			});
		} else {
			resultatSearch.textContent = "Aucun résultat trouvé.";
		}
	} catch (error) {
		console.error("Error:", error);
		
	}
}

document.addEventListener("DOMContentLoaded", animalSearch);
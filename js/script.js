async function animalSearch() {
	let requete = document.getElementById("animalSearchBar").value;

	let url;

	if (requete.length === 0) {
		url = "../pages/recherche_animal.php";
	} else {
		url = `../pages/recherche_animal.php?q=${encodeURIComponent(requete)}`;
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
				let animalDiv = document.createElement("div");

				pName.textContent = `Prénom: ${animal.prenom}`;
				pAge.textContent = `Âge: ${animal.age} ans`;
				pRace.textContent = `Race: ${animal.label}`;
				img.src = `data:image/jpeg;base64,${animal.image_data}`;
				link.href = `detail_animal.php?animal_id=${animal.animal_id}`;
				link.textContent = "Voir la fiche de l'animal";

				pName.classList.add("animalName");
				pAge.classList.add("animalAge");	
				pRace.classList.add("animalRace");
				img.classList.add("animalImage");
				link.classList.add("animalLink");
				animalDiv.classList.add("animal");


				animalDiv.appendChild(pName);
				animalDiv.appendChild(pAge);
				animalDiv.appendChild(pRace);
				animalDiv.appendChild(img);
				animalDiv.appendChild(link);

				
				resultatSearch.appendChild(animalDiv);
			});
		} else {
			resultatSearch.textContent = "Aucun résultat trouvé.";
		}
	} catch (error) {
		console.error("Error:", error);
		
	}
}

document.addEventListener("DOMContentLoaded", animalSearch);


// affichage du menu mobile
document.getElementById("button_menu_mobile").addEventListener("click", function () {
		const navbarMobile = document.getElementById("navbar_mobile");
		navbarMobile.classList.toggle("show");
	});


const carousel = document.getElementById("carouselExampleCaptions");
document.addEventListener("DOMContentLoaded", function () {
	if (window.screen.width < 768) {
		carousel.classList.add("d-none");
		carousel.classList.remove("d-block");
		
		const img = document.createElement("img");
		img.setAttribute("src", "../assets/images_page_accueil_mobile/ecureuil.jpg");
	img.setAttribute("alt", "ecureuil qui dévore une noissette sur une branche");
	img.style.width = "100%";
	img.style.height = "500px";
	img.style.marginTop = "100px";
	
	const navbar = document.getElementById("navbar");
	navbar.insertAdjacentElement("afterend", img)
}


});

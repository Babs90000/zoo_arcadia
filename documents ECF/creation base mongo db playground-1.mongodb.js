// MongoDB Playground
// Use Ctrl+Space inside a snippet or a string literal to trigger completions.

// The current database to use.
use("arcadia");

// Create a new document in the collection.
db.getCollection("decompte_animaux").insertMany([
	{ prenom: "Kavi", animal_id: "19", race: "elephant", decompte_visiteurs: 0 },
	{ prenom: "Maya", animal_id: "20", race: "elephant", decompte_visiteurs: 0 },
	{ prenom: "Anya", animal_id: "21", race: "elephant", decompte_visiteurs: 0 },
	{ prenom: "Peter", animal_id: "22", race: "elephant", decompte_visiteurs: 0 },
	{ prenom: "Kibo", animal_id: "23", race: "girafe", decompte_visiteurs: 0 },
	{ prenom: "Zuri", animal_id: "24", race: "girafe", decompte_visiteurs: 0 },
	{ prenom: "Kati", animal_id: "25", race: "girafe", decompte_visiteurs: 0 },
	{ prenom: "Ema", animal_id: "27", race: "zèbre", decompte_visiteurs: 0 },
	{ prenom: "Kito", animal_id: "28", race: "zèbre", decompte_visiteurs: 0 },
	{ prenom: "Amani", animal_id: "29", race: "zèbre", decompte_visiteurs: 0 },
	{ prenom: "Jabari", animal_id: "30", race: "zèbre", decompte_visiteurs: 0 },
	{ prenom: "Nia", animal_id: "31", race: "zèbre", decompte_visiteurs: 0 },
	{ prenom: "Kumba", animal_id: "32", race: "gorille", decompte_visiteurs: 0 },
	{ prenom: "Luna", animal_id: "33", race: "gorille", decompte_visiteurs: 0 },
	{ prenom: "Bobo", animal_id: "34", race: "gorille", decompte_visiteurs: 0 },
	{ prenom: "Mia", animal_id: "35", race: "gorille", decompte_visiteurs: 0 },
	{ prenom: "Titus", animal_id: "36", race: "gorille", decompte_visiteurs: 0 },
	{ prenom: "Tea", animal_id: "37", race: "paresseux", decompte_visiteurs: 0 },
	{ prenom: "Max", animal_id: "38", race: "paresseux", decompte_visiteurs: 0 },
	{ prenom: "Bella", animal_id: "39", race: "paresseux", decompte_visiteurs: 0 },
	{ prenom: "Budi", animal_id: "40", race: "orang-outan", decompte_visiteurs: 0 },
	{ prenom: "Siti", animal_id: "41", race: "orang-outan", decompte_visiteurs: 0 },
	{prenom: "Rimba",animal_id: "42",race: "orang-outan",decompte_visiteurs: 0,},
	{prenom: "Balthazar",animal_id: "43",race: "hippopotame",decompte_visiteurs: 0,},
	{prenom: "Hector",animal_id: "45",race: "hippopotame",decompte_visiteurs: 0,},
	{prenom: "Marta",animal_id: "46",race: "hippopotame",decompte_visiteurs: 0,},
	{prenom: "Stella",animal_id: "47",race: "hippopotame",decompte_visiteurs: 0,},
	{ prenom: "Léo", animal_id: "48", race: "loutre", decompte_visiteurs: 0 },
	{ prenom: "Mila", animal_id: "49", race: "loutre", decompte_visiteurs: 0 },
	{ prenom: "Oscar", animal_id: "50", race: "loutre", decompte_visiteurs: 0 },
	{ prenom: "Fifi", animal_id: "51", race: "loutre", decompte_visiteurs: 0 },
	{ prenom: "Nino", animal_id: "52", race: "loutre", decompte_visiteurs: 0 },
	{ prenom: "Grisou", animal_id: "53", race: "héron", decompte_visiteurs: 0 },
	{ prenom: "Blanchette", animal_id: "54", race: "héron", decompte_visiteurs: 0 },
	{ prenom: "Rubis", animal_id: "55", race: "héron", decompte_visiteurs: 0 },
	{ prenom: "Émeraude", animal_id: "56", race: "héro", decompte_visiteurs: 0 },
]);

var NomePokemon = document.querySelector('.pokenome');
var NumPokemon = document.querySelector('.pokenum');
var ImgPokemon = document.querySelector('#pokemon');

var form = document.querySelector('#formulario');
var input = document.querySelector('#pesquisarpokemon');

var buttonprev = document.querySelector('.btn-prev');
var buttonnext = document.querySelector('.bnt-next');
 

var habilidade0 = document.querySelector('.habilidade0');
var habilidade1 = document.querySelector('.habilidade1');
var tipopokemon = document.querySelector('#tipo');

var pokemonfemea = document.querySelector('#femea');

var nao = document.querySelector('#nao');

 
let searchpokemon = 1;
 
var fetchPokemon = async (pokemon) => {
 
    var APIResponse = await fetch(`https://pokeapi.co/api/v2/pokemon/${pokemon}`);
   
   
    if(APIResponse.status == 200){
        const data = await APIResponse.json();
        return data;
    }
    else{
        NomePokemon.innerHTML = 'Não encontrado!';
        NumPokemon.innerHTML = '';
    }
    
  

 
}
 
var renderPokemon = async (pokemon) => {
    var data = await fetchPokemon(pokemon);
    if (data){
    NomePokemon.innerHTML = data.name;
    NumPokemon.innerHTML = data.id;
   
    ImgPokemon.src = data['sprites']['versions']['generation-v']['black-white']['animated']['front_default'];
    if (pokemonfemea){
        pokemonfemea.src = data['sprites']['versions']['generation-v']['black-white']['animated']['front_female'];
        nao.innerHTML = '';
    }
    else{
        pokemonfemea.style.display = 'none';
        nao.innerHTML = 'Não existe!';
    }
    
    searchpokemon = data.id;
    
    habilidade0.innerHTML = data.abilities[0].ability.name;
    habilidade1.innerHTML = data.abilities[1].ability.name;
    tipopokemon.innerHTML = data.types[0].type.name;

}
    }
   
 
form.addEventListener('submit', (event) => {
 
    event.preventDefault();
 
    renderPokemon (input.value);
 
});
 
buttonprev.addEventListener('click', () => {
 
   searchpokemon -= 1;
    renderPokemon(searchpokemon);
 
});
 
buttonnext.addEventListener('click', () => {
 
    searchpokemon += 1;
    renderPokemon(searchpokemon);
 
});
 
renderPokemon(searchpokemon);

const api_url = "https://jsonplaceholder.typicode.com/posts"
const btn_carica = document.getElementById("btn_carica");
const tbl_post = document.getElementById("tbl_post");
btn_carica.addEventListener('click', riempiTabella);

function riempiTabella()
{
    console.log("riempi Tabella");
    scaricaPost();
}                                                       

async function scaricaPost()
{
    const risposta = await fetch(api_url);
    const datiPost = await risposta.json();
    //console.log(datiPost[0]);
    for (const i in datiPost)
    {
        //console.log(datiPost[i]["title"]);
        let row = tbl_post.insertRow(-1);
        row.insertCell(0).textContent = datiPost[i]["userId"];
        row.insertCell(1).textContent = datiPost[i]["id"];
        row.insertCell(2).textContent = datiPost[i]["title"];
        row.insertCell(3).textContent = datiPost[i]["body"];
    }
}
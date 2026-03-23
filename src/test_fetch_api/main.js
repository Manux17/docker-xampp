const api_url = "https://3000-firebase-struttura-framework-1768177530017.cluster-64pjnskmlbaxowh5lzq6i7v4ra.cloudworkstations.dev/api/products";
const btn_carica = document.getElementById("btn_carica");
const tbl_post = document.getElementById("tbl_post");
const btn_invia = document.getElementById("btn_invia");
btn_carica.addEventListener('click', riempiTabella);
btn_invia.addEventListener('click', inviaDati);

//avendo il metodo scaricaPost come async, qunado lo richiamamo dobbiamo mettere await
async function riempiTabella()
{
    console.log("riempi Tabella");
    let datiPost = await scaricaPost();
    console.log(datiPost);

    tbl_post.innerHTML = "<tr><th>product_id</th><th>name</th><th>description</th><th>price</th></tr>";

    for (const i in datiPost)
    {
        //console.log(datiPost[i]["title"]);
        let row = tbl_post.insertRow(-1);
        row.insertCell(0).textContent = datiPost[i]["product_id"];
        row.insertCell(1).textContent = datiPost[i]["name"];
        row.insertCell(2).textContent = datiPost[i]["description"];
        row.insertCell(3).textContent = datiPost[i]["price"];
    }
}                                                       

//prendiamo il JSON e facciamo la return 
async function scaricaPost()
{
    try
    {
        const risposta = await fetch(api_url);
        if(!risposta.ok)
        {
            throw new Error("Response status: ${risposta.status}");
        }
        const datiPost = await risposta.json();
        return datiPost;
    }
    catch(error)
    {
        console.error(error.message);
        return [];
    }
    
}

async function inviaDati()
{
    const name = document.getElementById(name).textContent;
    const description = document.getElementById(description).textContent;
    const price = document.getElementById(price).textContent;
    console.log(name);
    console.log(description);
    console.log(price);
}
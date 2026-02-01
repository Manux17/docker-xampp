async function hashPassword(password) 
{
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest("SHA-256", data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

login = document.getElementById("LOGIN");
if (login !== null)
{
    login.addEventListener("submit", async function (e) 
    {
        e.preventDefault();
    
        const passwordInput = document.getElementById("password");
        const hashedPassword = await hashPassword(passwordInput.value);
    
        passwordInput.value = hashedPassword;
        this.submit();
    });
}

registrazione = document.getElementById("REGISTRAZIONE");
if (registrazione !== null)
{
    registrazione.addEventListener("submit", async function (e) 
    {
        console.log("CIAO CIAO");
        e.preventDefault();
    
        const passwordInput = document.getElementById("password");
        const hashedPassword = await hashPassword(passwordInput.value);
    
        passwordInput.value = hashedPassword;
        this.submit();
    });
}

async function hashPassword(password) 
{
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest("SHA-256", data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

document.getElementById("login").addEventListener("submit", async function (e) 
{
    e.preventDefault();

    const passwordInput = document.getElementById("password");
    const hashedPassword = await hashPassword(passwordInput.value);

    passwordInput.value = hashedPassword;
    this.submit();
});
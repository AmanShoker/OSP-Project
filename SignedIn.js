function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
const isSignedIn = getCookie('isSignedIn');
const username = getCookie('username');

if (isSignedIn === 'true' && username) {
    document.getElementById('signIn-Up').innerHTML = `<a href="Homepage.html" onclick="signOut()" class="signOut">Sign Out</a>`;
}

function signOut() {
    document.cookie = 'isSignedIn=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
    document.cookie = 'username=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';

    window.location.href = 'Homepage.html';
}
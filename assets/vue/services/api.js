export async function sendForm(data) {
    const res = await fetch('/form', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
    debugger;
    if (res.status === 500) throw new Error('Błąd wysyłki formularza');

    return res.json();
}

// 22120123 - Long Nguyen - Practical 15:00 -> 17:00

// Validates order search form
function validateSearchForm() {
    const surname = document.querySelector('input[name="surname"]');
    if (!surname.value.trim()) {
        alert("Customer surname is required.");
        return false;
    }
    return true;
}

// Validates deposit form
function validateDepositForm() {
    const depositInput = document.getElementById('deposit');
    const deposit = parseFloat(depositInput.value);
    if (isNaN(deposit) || deposit < 0) {
        alert("Deposit must be a positive number.");
        return false;
    }
    return true;
}

// Updates total due
function updateOwing(total) {
    const deposit = parseFloat(document.getElementById('deposit').value);
    let owing;
    if (isNaN(deposit) || deposit < 0) {
        owing = total;
    } else {
        owing = total - deposit;
    }
    document.getElementById('owing').value = '$' + owing.toFixed(2);
}

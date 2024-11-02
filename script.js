const form = document.getElementById('form');

// to append the new trans
const transactionsList = document.createElement('ul');
document.body.appendChild(transactionsList);

const totalAmount = document.createElement('h2');
totalAmount.id = 'total-amount';
document.body.appendChild(totalAmount);

let transactions = [];
function addTransaction(event) {
    event.preventDefault(); 

    const description = document.getElementById('description').value;
    const amount = parseFloat(document.getElementById('amount').value);
    const date = document.getElementById('date').value;
    const type = document.getElementById('type').value;

    const transaction = { description, amount, date, type };
 
    console.log(transaction)
    transactions.push(transaction);

    form.reset();

    updateTransactionList();
}

function updateTransactionList() {
    transactionsList.innerHTML = ''; 
    transactions.forEach(transaction => {
        const li = document.createElement('li');
        li.textContent = `${transaction.description} - ${transaction.type} $${transaction.amount} on ${transaction.date}`;
        transactionsList.appendChild(li);
    });
}


form.addEventListener('submit', addTransaction);


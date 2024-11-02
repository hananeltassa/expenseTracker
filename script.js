const form = document.getElementById('form');
const transactionsList = document.getElementById('transactionsList'); 
const totalAmount = document.getElementById('total-amount');


let transactions = [];

// Load transactions from localStorage on page load 
document.addEventListener('DOMContentLoaded', () => {
    const savedTransactions = localStorage.getItem('transactions');
    if (savedTransactions) {
        transactions = JSON.parse(savedTransactions);
        updateTransactionList(transactions);
    }
});

function addTransaction(event) {
    event.preventDefault(); 

    const description = document.getElementById('description').value;
    const amount = parseFloat(document.getElementById('amount').value);
    const date = document.getElementById('date').value;
    const type = document.getElementById('type').value;

    if (amount <= 0) {
        alert("Please enter a valid positive amount.");
        return;
    }

    const transaction = { description, amount, date, type };
    console.log(transaction)
    transactions.push(transaction);
    form.reset();
    updateTransactionList(transactions);
}

function updateTransactionList(transactionsDisplay) {
    transactionsList.innerHTML = ''; 
    let total = 0;

    transactionsDisplay.forEach((transaction, index) => { //getiing the index
        const li = document.createElement('li');
        li.setAttribute('data-type', transaction.type);
        li.textContent = `${transaction.description} - ${transaction.type} $${transaction.amount} on ${transaction.date}`;
        
        //Edit button
        const editButton = document.createElement('button');
        editButton.textContent='Edit';
        editButton.style.marginLeft = '10px';
        editButton.onclick = () => editTransaction(index);


        // delete button
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.style.marginLeft = '10px'; 
        deleteButton.onclick = () => deleteTransaction(index);
        
        li.appendChild(editButton)
        li.appendChild(deleteButton);
        transactionsList.appendChild(li);

        total += (transaction.type === 'income' ? transaction.amount : -transaction.amount);
    });
    
    totalAmount.textContent = `Total Amount: $${total.toFixed(2)}`; 

    // Save transactions to localStorage
    localStorage.setItem('transactions', JSON.stringify(transactions));
}

function editTransaction(index){
    const transaction = transactions[index];
    
    document.getElementById('description').value = transaction.description;
    document.getElementById('amount').value = transaction.amount;
    document.getElementById('date').value = transaction.date;
    document.getElementById('type').value = transaction.type;

    form.dataset.editIndex = index; 
}

function deleteTransaction(index) {
    transactions.splice(index, 1); 
    updateTransactionList(transactions); 
}

form.addEventListener('submit', (event) => {
    event.preventDefault(); //prevent from submission
    const editIndex = form.dataset.editIndex;

    if (editIndex) {
        transactions[Number(editIndex)] = { 
            description: document.getElementById('description').value,
            amount: parseFloat(document.getElementById('amount').value),
            date: document.getElementById('date').value,
            type: document.getElementById('type').value
        };
        delete form.dataset.editIndex; 
        form.reset();
    } else {
        addTransaction(event);
    }

    updateTransactionList(transactions);
});

document.getElementById('filterType').addEventListener('change', filterTransactions);
document.getElementById('minAmount').addEventListener('input', filterTransactions); 
document.getElementById('maxAmount').addEventListener('input', filterTransactions);
document.getElementById('descriptionFilter').addEventListener('input', filterTransactions);

function filterTransactions() {
    const filterType = document.getElementById('filterType').value;
    const minAmount = parseFloat(document.getElementById('minAmount').value) || 0; 
    const maxAmount = parseFloat(document.getElementById('maxAmount').value) || Infinity;
    const descriptionFilter = document.getElementById('descriptionFilter').value.toLowerCase(); 


    const filteredTransactions = transactions.filter(transaction => { //creates new arr that include the filtered transactions
        const amountCondition = transaction.amount >= minAmount && transaction.amount <= maxAmount;
        const typeCondition = filterType === 'all' || transaction.type === filterType;
        const descriptionCondition = transaction.description.toLowerCase().includes(descriptionFilter); 

        return amountCondition && typeCondition && descriptionCondition; 
    });

    updateTransactionList(filteredTransactions); 
}

function resetFilters() {
    document.getElementById('descriptionFilter').value = '';
    document.getElementById('minAmount').value = '';
    document.getElementById('maxAmount').value = '';
    document.getElementById('filterType').value = 'all';

    updateTransactionList(transactions); 
}

totalAmount.textContent = `Total Amount: $0.00`; 

document.getElementById('darkModeToggle').addEventListener('change',
   function()
 {
    document.body.classList.toggle('dark', this.checked);
  });
  
  document.getElementById('paymentForm').addEventListener('submit', function(e) 
  {
    const name = this.name.value.trim();
    const amount = parseFloat(this.amount.value);
    const method = this.method.value;
  
    if (name === '' || isNaN(amount) || amount <= 0 || method === '') {
      e.preventDefault();
      alert("Please fill out all fields with valid data.");
    }
  });

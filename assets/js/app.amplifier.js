
$(function() {
    $('#nida_number').mask('00000000 00000 00000 00');

class NyangAmplifier {
constructor() {
    this.bearerToken = 'token';
}

verifyTZNIN(nida_number) {
// Send AJAX request to the server
$.ajax({
url: 'app/controller/app_controller.php',  // Adjust the path to your controller
method: 'POST',
headers: {  Authorization: `Bearer ${this.bearerToken}`, },
data: { nida_number: nida_number },
dataType: 'JSON' ,
success: function(response) {
    // Assuming the response is JSON with the required details
     if (response.success) {
        const data =response.data;
        $('#nida_response').html(`
            <div class="alert alert-success">
                <p><strong>NIDA Verification Success:</strong></p>
                <p><strong>First Name:</strong> ${data.firstname}</p>
                <p><strong>Middle Name:</strong> ${data.middlename}</p>
                <p><strong>Last Name:</strong> ${data.lastname}</p>
                <p><strong>Nationality:</strong> ${data.nationality}</p>
                <p><strong>NIN:</strong> ${data.nin}</p>
            </div>
        `);
    } else {
        $('#nida_response').html(`
            <div class="alert alert-danger">NIDA verification failed: ${response.message}</div>
        `);
    }
},
error: function(xhr, status, error) {
    $('#nida_response').html(`
        <div class="alert alert-danger">Error: ${error}</div>
    `);
}
});
}

init() {
// Handle form submission
$('#nidaForm').on('submit', (e) => {
    e.preventDefault();
    const nida_number = $('#nida_number').val();
    if (nida_number) {
        this.verifyTZNIN(nida_number);
    } else {
        $('#nida_response').html(`
            <div class="alert alert-warning">Please enter a NIDA number.</div>
        `);
    }
});
}
}

// Initialize the NyangAmplifier class
new NyangAmplifier().init();
});
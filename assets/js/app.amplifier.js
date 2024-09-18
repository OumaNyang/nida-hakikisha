/*
@Module: Hakikisha NIDA Module
@Author: Ouma Nyang
@License: MIT License: Copyright (c) 2019 - 2024
*/
$(function() {
"use strict";
$('#nida_number').mask('00000000 00000 00000 00');

class HakikishaNIDA {
constructor() {
this.bearerToken = 'token_here'; // You should replace 'token' with your actual token
this.spinner = `
    <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>`;
this.submitButton = $('form button[type="submit"]');
}

HakikishaNIDA(nida_number) {

    this.submitButton.attr('disabled', true);

    $.ajax({
    url: 'app/controller/app_controller', 
    method: 'POST',
    headers: {
        Authorization: `Bearer ${this.bearerToken}`,
    },
    data: { verify_nida_nin: nida_number },
    dataType: 'JSON',
    success: (response) => {   
        this.submitButton.attr('disabled', false);

        if (response.success && response.data !== null) {
            let data = response.data;
            $('#nida_response').html(`
                <div class="card border-success border border-2">
                <div class="card-body text-start">
                <h6 class="card-title text-success"> ${response.message}</h6>
                <p><strong>First Name:</strong> ${data.FIRSTNAME}</p>
                <p><strong>Middle Name:</strong> ${data.MIDDLENAME}</p>
                <p><strong>Last Name:</strong> ${data.SURNAME}</p>
                <p><strong>Nationality:</strong> ${data.NATIONALITY}</p>
                <p><strong>Sex:</strong> ${data.SEX}</p>
                <p><strong>Date of Birth:</strong> ${data.DATEOFBIRTH}</p>
                <p><strong>NIN:</strong> ${data.NIN}</p>
                </div>  
                </div>  

            `);
        } else {
            $('#nida_response').html(`
                <div class="alert alert-danger">NIDA verification failed: ${response.message}</div>
            `);
        }
    },
    error: (xhr, status, error) => {
        this.submitButton.attr('disabled', false);
        $('#nida_response').html(`
            <div class="alert alert-danger">Error: ${error}</div>
        `);
    }
});
}

init() {

$('#nidaForm').on('submit', (e) => {
    e.preventDefault();
    const nida_number = $('#nida_number').val();
    this.submitButton.attr('disabled', true);
    $('#nida_response').html(this.spinner);    

    if (nida_number) {
        this.HakikishaNIDA(nida_number);
    } else {
        this.submitButton.attr('disabled', false);
        $('#nida_response').html(`
            <div class="alert alert-warning">Please enter a NIDA number.</div>
        `);
    }
});
}
}

// Initialize the HakikishaNIDA
new HakikishaNIDA().init();
});

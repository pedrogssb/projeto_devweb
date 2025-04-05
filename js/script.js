$(document).ready(function() {
    $('#cpf').mask('000.000.000-00', {reverse: true});
    
    $('input[name="atividadeLaborativa"]').change(function() {
        if ($('#atividadeLaborativaS').is(':checked')) {
            $('#descricaoAtividadeDiv').show();
        } else {
            $('#descricaoAtividadeDiv').hide();
        }
    });
    
    $('#outrasMolestiasFamilia').change(function() {
        $('#descOutrasMolestiasFamilia').prop('disabled', !this.checked);
        if (!this.checked) $('#descOutrasMolestiasFamilia').val('');
    });
    
    $('#outrasMolestiasPessoal').change(function() {
        $('#descOutrasMolestiasPessoal').prop('disabled', !this.checked);
        if (!this.checked) $('#descOutrasMolestiasPessoal').val('');
    });
    
    $('#alergiasMedicas').change(function() {
        $('#descAlergiasMedicas').prop('disabled', !this.checked);
        if (!this.checked) $('#descAlergiasMedicas').val('');
    });
    
    $('#cirurgias').change(function() {
        $('#descCirurgias').prop('disabled', !this.checked);
        if (!this.checked) $('#descCirurgias').val('');
    });
    
    $('#medicamentos').change(function() {
        $('#descMedicamentos').prop('disabled', !this.checked);
        if (!this.checked) $('#descMedicamentos').val('');
    });
    
    $('#pcd').change(function() {
        if ($(this).val() === 'sim') {
            $('#descPcdDiv').show();
        } else {
            $('#descPcdDiv').hide();
        }
    });
    
    $('#genero').change(function() {
        if ($(this).val().includes('Mulher cis' ) || $(this).val().includes('Homem trans')) {
            $('#gestacionalAccordion').show();
        } else {
            $('#gestacionalAccordion').hide();
        }
    });
    
    $('#gestacoes').change(function() {
        if ($(this).val() === 'sim') {
            $('#quantidadeGestacoesDiv').show();
            $('#cesariaDiv').show();
            $('#partoNormalDiv').show();
        } else {
            $('#quantidadeGestacoesDiv').hide();
            $('#cesariaDiv').hide();
            $('#partoNormalDiv').hide();
            $('#quantidadeCesariaDiv').hide();
            $('#quantidadePartoNormalDiv').hide();
        }
    });
    
    $('#cesaria').change(function() {
        if ($(this).val() === 'sim') {
            $('#quantidadeCesariaDiv').show();
        } else {
            $('#quantidadeCesariaDiv').hide();
        }
    });
    
    $('#partoNormal').change(function() {
        if ($(this).val() === 'sim') {
            $('#quantidadePartoNormalDiv').show();
        } else {
            $('#quantidadePartoNormalDiv').hide();
        }
    });
    
    $('#examForm').submit(function(e) {
        e.preventDefault();
        
        if (this.checkValidity()) {
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
            
            this.reset();
            $(this).removeClass('was-validated');
            
            if (!$('#genero').val().includes('Mulher')) {
                $('#gestacionalAccordion').hide();
            }
        } else {
            $(this).addClass('was-validated');
        }
    });
});
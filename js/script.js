$(document).ready(function() {

    $('#cpf').mask('000.000.000-00', {reverse: true});

    $('input[name="atividadeLaborativa"]').change(function() {
        if ($('#atividadeLaborativaS').is(':checked')) {
            $('#descricaoAtividadeDiv').show();
            $('#descricaoAtividade').prop('required', true); 
        } else {
            $('#descricaoAtividadeDiv').hide();
            $('#descricaoAtividade').val(''); 
            $('#descricaoAtividade').prop('required', false); 
        }
    });

    function setupCheckboxDependentInput(checkboxId, inputId, nameOnChecked) {
        const checkbox = $(checkboxId);
        const input = $(inputId);

        function updateInputState() {
            if (checkbox.is(':checked')) {
                input.prop('disabled', false);
                input.attr('name', nameOnChecked);
            } else {
                input.prop('disabled', true);
                input.val(''); 
                input.removeAttr('name');
            }
        }

        checkbox.change(updateInputState);

        updateInputState();
    }

    setupCheckboxDependentInput('#outrasMolestiasFamilia', '#descOutrasMolestiasFamilia', 'outrasMolestiasFamiliaDesc');
    setupCheckboxDependentInput('#outrasMolestiasPessoal', '#descOutrasMolestiasPessoal', 'outrasMolestiasPessoalDesc');
    setupCheckboxDependentInput('#alergiasMedicas', '#descAlergiasMedicas', 'alergias');
    setupCheckboxDependentInput('#cirurgias', '#descCirurgias', 'cirurgias');
    setupCheckboxDependentInput('#medicamentos', '#descMedicamentos', 'medicamentosContinuos');


    $('#pcd').change(function() {
        if ($(this).val() === 'sim') {
            $('#descPcdDiv').show();
            $('#descPcd').prop('required', true); 
            $('#descPcd').attr('name', 'descPCD'); 
        } else {
            $('#descPcdDiv').hide();
            $('#descPcd').val(''); 
            $('#descPcd').prop('required', false);
            $('#descPcd').removeAttr('name'); 
        }
    });

    $('#genero').change(function() {
        const selectedGender = $(this).val();
        const gestacionalAccordion = $('#gestacionalAccordion');

        if (selectedGender === 'Mulher cis' || selectedGender === 'Homem trans' || selectedGender === 'Não binário') {
            gestacionalAccordion.show();
            $('#gestacoes').prop('required', true);
        } else {
            gestacionalAccordion.hide();
            $('#gestacoes').val('').prop('required', false);
            
            $('#quantidadeGestacoesDiv').hide();
            $('#quantidadeGestacoes').val('').prop('required', false);

            $('#cesariaDiv').hide();
            $('#cesaria').val('').prop('required', false);

            $('#quantidadeCesariaDiv').hide();
            $('#quantidadeCesaria').val('').prop('required', false);

            $('#partoNormalDiv').hide();
            $('#partoNormal').val('').prop('required', false);

            $('#quantidadePartoNormalDiv').hide();
            $('#quantidadePartoNormal').val('').prop('required', false);

            $('#intercorrenciasGestacionaisDiv').hide();
            $('#intercorrenciasGestacionais').val('');
        }
        $('#gestacoes').trigger('change'); 
    });

    $('#gestacoes').change(function() {
        if ($(this).val() === 'sim') {
            $('#quantidadeGestacoesDiv').show();
            $('#quantidadeGestacoes').prop('required', true);
            
            $('#cesariaDiv').show();
            $('#cesaria').prop('required', true);

            $('#partoNormalDiv').show();
            $('#partoNormal').prop('required', true);

            $('#intercorrenciasGestacionaisDiv').show();
        } else {
            $('#quantidadeGestacoesDiv').hide();
            $('#quantidadeGestacoes').val('').prop('required', false);

            $('#cesariaDiv').hide();
            $('#cesaria').val('').prop('required', false);

            $('#quantidadeCesariaDiv').hide();
            $('#quantidadeCesaria').val('').prop('required', false);

            $('#partoNormalDiv').hide();
            $('#partoNormal').val('').prop('required', false);

            $('#quantidadePartoNormalDiv').hide();
            $('#quantidadePartoNormal').val('').prop('required', false);

            $('#intercorrenciasGestacionaisDiv').hide();
            $('#intercorrenciasGestacionais').val('');
        }
        $('#cesaria').trigger('change');
        $('#partoNormal').trigger('change');
    });
    $('#cesaria').change(function() {
        if ($(this).val() === 'sim') {
            $('#quantidadeCesariaDiv').show();
            $('#quantidadeCesaria').prop('required', true);
        } else {
            $('#quantidadeCesariaDiv').hide();
            $('#quantidadeCesaria').val('').prop('required', false);
        }
    });

    $('#partoNormal').change(function() {
        if ($(this).val() === 'sim') {
            $('#quantidadePartoNormalDiv').show();
            $('#quantidadePartoNormal').prop('required', true);
        } else {
            $('#quantidadePartoNormalDiv').hide();
            $('#quantidadePartoNormal').val('').prop('required', false);
        }
    });

    $('#examForm').submit(function(e) {
        const form = this; 
        form.classList.add('was-validated');
        e.preventDefault(); 

        if (form.checkValidity()) {
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();

            $('#confirmationModal button.btn-success').one('click', function() {
                var formData = new FormData(form); 
                $(this).prop('disabled', true).text('Enviando...');

                $.ajax({
                    url: $(form).attr('action'),
                    type: $(form).attr('method'), 
                    data: formData,
                    processData: false, 
                    contentType: false, 
                    success: function(response) {

                        confirmationModal.hide();

                        console.log(response); 

                        if (response.success) { 
                            alert('Formulário enviado com sucesso!');
                            form.reset();
                            form.classList.remove('was-validated'); 

                            window.location.href = 'index.html'; 

                        } else {
                            alert('Erro ao enviar formulário: ' + (response.message || 'Erro desconhecido.'));
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        confirmationModal.hide();
                        alert('Ocorreu um erro ao tentar enviar o formulário. Por favor, tente novamente.');
                        console.error('Erro na requisição AJAX:', textStatus, errorThrown, jqXHR.responseText);
                    },
                    complete: function() {
                        $('#confirmationModal button.btn-success').prop('disabled', false).text('Confirmar');
                    }
                });
            });

        } else {
        }
    });

    $('input[name="atividadeLaborativa"]').trigger('change');
    setupCheckboxDependentInput('#outrasMolestiasFamilia', '#descOutrasMolestiasFamilia', 'outrasMolestiasFamiliaDesc');
    setupCheckboxDependentInput('#outrasMolestiasPessoal', '#descOutrasMolestiasPessoal', 'outrasMolestiasPessoalDesc');
    setupCheckboxDependentInput('#alergiasMedicas', '#descAlergiasMedicas', 'alergias');
    setupCheckboxDependentInput('#cirurgias', '#descCirurgias', 'cirurgias');
    setupCheckboxDependentInput('#medicamentos', '#descMedicamentos', 'medicamentosContinuos');
    
    $('#pcd').trigger('change');
    $('#genero').trigger('change');

});
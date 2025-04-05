function mostrarPagina(idPagina){
    const paginas = document.querySelectorAll('div[id^="pagina"]');
    paginas.forEach(pagina =>{
        pagina.style.display = 'none'
    });

    const pagina = document.getElementById(idPagina);
    if(pagina) {
        pagina.style.display = 'block';
    }
}


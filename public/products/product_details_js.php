<script>
    $(document).ready(function() {
        //TESTE CAROUSEL
        let slide_index = 0;
        const slides = $('.slideshow_container .img');

        //Função para mostrar apenas a 1ª img do array
        function mostrarSlide(index) {
            slides.hide(); // Esconde todas as imagens
            slides.eq(index).show(); // Mostra apenas a imagem atual
        }

        // Mostrar a 1ª imagem do array
        mostrarSlide(slide_index);

        // Função para mudar de imagem com os botões prev e next
        slide = function(direcao) {
            slide_index += direcao;

            // Voltar à última img
            if (slide_index < 0) {
                slide_index = slides.length - 1;
            }
            // Voltar à primeira img
            else if (slide_index >= slides.length) {
                slide_index = 0;
            }

            // Mostrar a nova imagem
            mostrarSlide(slide_index);
        };

        //Função para mostrar a imagem que for carregada no seletor de baixo
        img_click = function(index) {
            slide_index = index; // Recebe o indice que foi incrementado por cada imagem no loop while
            mostrarSlide(slide_index);
        };

    });
</script>
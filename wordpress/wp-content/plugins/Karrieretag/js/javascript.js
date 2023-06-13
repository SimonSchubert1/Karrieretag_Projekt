function change($num){
    const checkbox = document.querySelectorAll('.checkbox');
    const exportboxes = document.querySelectorAll('.wrapper');

    console.log(exportboxes);


    if (checkbox[$num].checked) {
        exportboxes[$num].classList.add('visible');
        console.log($num);
        console.log('is checked')
    } else{
        exportboxes[$num].classList.remove('visible');
        console.log($num);
        console.log('is not checked')
    }
}

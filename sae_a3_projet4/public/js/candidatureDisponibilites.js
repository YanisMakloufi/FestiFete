const addTagFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('button');
    removeFormButton.innerText = '❌';

    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        if(creneaux.dataset.index > 1){
            e.preventDefault();
            creneaux.dataset.index--;
            item.remove();
        }
    });
}

const addFormToCollection = () => {
    const item = document.createElement('fieldset');

    item.innerHTML = creneaux
        .dataset
        .prototype
        .replace(
            /__name__/g,
            creneaux.dataset.index
        );

    creneaux.appendChild(item);

    creneaux.dataset.index++;
    addTagFormDeleteLink(item);
};

document.querySelector('.add_item_link').addEventListener("click", addFormToCollection);

const creneaux = document.querySelector('#disponibilites')
addFormToCollection();
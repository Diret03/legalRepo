function parseRow(text) {

    let tRowText = '';

    for (let i = 0; i < text.length ; i++) {
        tRowText += text[i];

        if (text[i+1] === '{'){
            let variable = ''

            for (let j = i+2; j < text.length; j++) {

                variable += text[j];
                if(text[j] === '}'){
                    i = j + 2;
                    break;
                }
            }

            tRowText += "'"+variable+"'";
        }
    }

    return tRowText;
}

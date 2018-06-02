var btnSubmit = document.getElementById('submit')
/**
 * Usando addEventListener as ações predefinidas do botão não serão sobrescritas. Isso pode gerar conflitos no retorno do 
 * método da API pois o trabalho é com dois bancos de dados
 * Então ao usar addEventListener deve-se evitar recuperar o retorno do método da API pois provavelmente não funcionará
 */

btnSubmit.addEventListener('click', (evt) => {
//btnSubmit.onclick = function(event){
//    event.preventDefault();
    const config = {
        baseURL: 'http://localhost:8080/',
        workspace: 'workspace-5f833b81'
    }

    const api = new SemanticAPI(config)
    let resource = new Resource('household-appliance', 'house-app', 'http://product.com#household-appliance')

    resource.addVocabulary('schema', 'http://schema.org/')
    resource.addVocabulary('dcat', 'http://www.w3.org/ns/dcat#')
    resource.addVocabulary('topo', 'http://data.ign.fr/def/topo#')
    resource.addVocabulary('vcard', 'http://www.w3.org/2006/vcard/ns#')
    resource.addVocabulary('sioc', 'http://rdfs.org/sioc/ns#')
    resource.addVocabulary('rev', 'http://purl.org/stuff/rev#')

    const productName = document.getElementById('name').innerText
    const propertyName = new Property('name', productName, false, '')
    resource.addProperty('schema', propertyName)

    const productColor = document.getElementById('color').innerText
    const propertyColor = new Property('color', productColor, false, '')
    resource.addProperty('schema', propertyColor)

    const productBrand = document.getElementById('brand').innerText
    const propertyBrand = new Property('Brand', productBrand, false, '')
    resource.addProperty('schema', propertyBrand)

    const productWeight = document.getElementById('weight').innerText
    const propertyWeight = new Property('weight', productWeight, false, '')
    resource.addProperty('schema', propertyWeight)

    const productPrice = document.getElementById('price').innerText
    const propertyPrice = new Property('price', productPrice, false, '')
    resource.addProperty('schema', propertyPrice)

    const productTags = []
    document.querySelectorAll('.tagged_as a').forEach(element => {
        productTags.push(element.innerText)
    })
    const tags = productTags.join(' ')
    const propertyTags = new Property('keywords', tags, false, '')
    resource.addProperty('schema', propertyTags)

    const productSize = document.getElementById('size').innerText
    const propertySize = new Property('size', productSize, false, '')
    resource.addProperty('dcat', propertySize)

    const productVoltage = document.getElementById('voltage').innerText
    const propertyVoltage = new Property('voltage', productVoltage, false, '')
    resource.addProperty('topo', propertyVoltage)

    const propertySE = new Property('ns', '', true, '')
    resource.addProperty('vcard', propertySE)

    const productSound = document.getElementById('sound').innerText
    const propertySound = new Property('sound', productSound, false, 'ns')
    resource.addProperty('vcard', propertySound)

    const productEmail = document.getElementById('email').innerText
    const propertyEmail = new Property('email', productEmail, false, 'ns')
    resource.addProperty('vcard', propertyEmail)

    const productSite = document.getElementById('site').innerText
    const propertySite = new Property('site', productSite, true, '')
    resource.addProperty('sioc', propertySite)

    const productComment = document.getElementById('comment').value
    const propertyComment = new Property('comment', productComment, false, '')
    resource.addProperty('rev', propertyComment)

    const productRating =  document.querySelector('.stars .active').innerText
    const propertyRating = new Property('rating', productRating, false, '')
    resource.addProperty('rev', propertyRating)

    console.log(resource)

    api.saveResource(resource)
    /**
     * .then e .catch estão comentados pois estamos usando a função addEventListener e provavelmente o método não funcionará adequadamente para tratamento com .then e .catch,
     * pois addEventListener não sobrescreve as ações predefinidas do blog mas sim trabalha concomitantemente
     * Enquanto o blog grava no mySql a API do SemanticMake grava em uma triple store
     */
    
    //.then(json => alert(`Recurso salvo com sucesso\nSeu workspace é: ${json.workspace}\nO ID do recurso é: ${json.resourceId}`))
    //.catch(error => alert(`Problema de conexão ao tentar salvar a ontologia\n${error.message}`))
})
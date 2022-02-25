function loadArticles(event) {
    const keys = Object.keys(event)
    keys.forEach(function (key, index) {
        const urlArticleView = "/article/"
        const urlArticleEdit = "/article/edit/"
        const urlCommentCreate = "/comment/create/"
        $("#articles-wrapper").append(`<div>
            <h3>${event[key].articleTitle}</h3>
            <p>${event[key].articleContent}</p>
            <p>${event[key].articleAuthor}</p>
            <a type="button" class="btn btn-outline-primary" href="${urlArticleView+event[key].articleId}">view</a> ` +
            (event[key].articleAuthor === event.user ? `<a type="button" class="btn btn-outline-primary" href="${urlArticleEdit+event[key].articleId}">edit</a>` : '') +`
            <a href="${urlCommentCreate+event[key].articleId}" class="btn btn-outline-primary">Comment</a>
            <hr/>
        </div>`)
    })

}

function errorArticles(error) {
    console.log(error)
}

$(document).ready(function(){
    $.get("/ajax/all/articles").then(loadArticles).catch(errorArticles)
})
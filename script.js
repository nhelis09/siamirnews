document.addEventListener('DOMContentLoaded', function() {
    loadTopics();
    const topicId = getUrlParameter('topic_id');
    if (topicId) {
        loadComments(topicId);
        document.getElementById('topic_id').value = topicId;
    }
});

function loadTopics() {
    fetch('get_topics.php')
        .then(response => response.json())
        .then(data => {
            const topicsDiv = document.getElementById('topics');
            topicsDiv.innerHTML = '';
            data.forEach(topic => {
                const topicElement = document.createElement('div');
                topicElement.innerHTML = `<h3>${topic.title}</h3><p>${topic.content}</p><a href="index.php?topic_id=${topic.id}">View Comments</a>`;
                topicsDiv.appendChild(topicElement);
            });
        });
}

function loadComments(topicId) {
    fetch('get_comments.php?topic_id=' + topicId)
        .then(response => response.json())
        .then(data => {
            const commentsDiv = document.getElementById('comments');
            commentsDiv.innerHTML = '';
            data.forEach(comment => {
                const commentElement = document.createElement('div');
                commentElement.innerHTML = `<p>${comment.content}</p>`;
                commentsDiv.appendChild(commentElement);
            });
        });
}

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    const results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

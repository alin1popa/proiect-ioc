function like(id, type) {
	$.post("like.php", {id: id, type: type}, function( data ) {
		var typestr;
		if (type === 0)
			typestr = "like";
		else if (type === 1)
			typestr = "watch";
		else if (type === 2)
			typestr = "recommend";
		
		if (data === "1") {
			$(`#${typestr}pic_${id}`).attr('src', `images/${typestr}_icon_r.jpg`);
			$(`#${typestr}nr_${id}`).text(parseInt($(`#${typestr}nr_${id}`).text()) + 1);
		}
		else if (data === "0"){
			$(`#${typestr}pic_${id}`).attr('src', `images/${typestr}_icon.jpg`);
			$(`#${typestr}nr_${id}`).text(parseInt($(`#${typestr}nr_${id}`).text()) - 1);
		}
	});
}

function createMultimediaBox(item) {
	return `
		<div class='multimedia ${item['type']}'>
			<div class='multimediaheaderbar'>
				<div class='multimediatype'>${item['type']}</div>
				<div class='multimediareason'>Watched by 5 friends</div>
			</div>
			<a href="view.php?id=${item['id']}">
				<img src='https://i.pinimg.com/736x/fd/5e/66/fd5e662dce1a3a8cd192a5952fa64f02--classic-poster-classic-movies-posters.jpg' class='multimediaimg' width=300/>
			</a>
			<div class='multimediainfobar'>
				<div class='infospace'>
					<img id='likepic_${item['id']}' src='images/like_icon${item['liked'] ? '_r' : ''}.jpg' height=30 class='multimediaicon likeicon' onClick='like(${item['id']}, 0)'/>
					<span id='likenr_${item['id']}' class='infonr'>${item['wholiked'].length + (item['liked']?1:0)}</span>
				</div>
				<div class='infospace'>
					<img id='watchpic_${item['id']}' src='images/watch_icon${item['watched'] ? '_r' : ''}.png' height=30 class='multimediaicon watchicon' onClick='like(${item['id']}, 1)'/>
					<span id='watchnr_${item['id']}' class='infonr'>${item['whowatched'].length + (item['watched']?1:0)}</span>
				</div>
				<div class='infospace'>
					<img id='recommendpic_${item['id']}' src='images/recommend_icon${item['recommended'] ? '_r' : ''}.png' height=30 class='multimediaicon recommendicon' onClick='like(${item['id']}, 2)'/>
					<span id='recommendnr_${item['id']}' class='infonr'>${item['whorecommended'].length + (item['recommended']?1:0)}</span>
				</div>
			</div>
		</div>
	`;
}
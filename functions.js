function like(id) {
	$.post("like.php", {id: id}, function( data ) {
		if (data === "1") {
			$("#likepic_"+id).attr('src', 'images/like_icon_r.jpg');
			$("#likenr_"+id).text(parseInt($("#likenr_"+id).text()) + 1);
		}
		else if (data === "0"){
			$("#likepic_"+id).attr('src', 'images/like_icon.jpg');
			$("#likenr_"+id).text(parseInt($("#likenr_"+id).text()) - 1);
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
			<img src='https://i.pinimg.com/736x/fd/5e/66/fd5e662dce1a3a8cd192a5952fa64f02--classic-poster-classic-movies-posters.jpg' class='multimediaimg' width=300/>
			<div class='multimediainfobar'>
				<div class='infospace'>
					<img id='likepic_${item['id']}' src='images/like_icon${item['liked'] ? '_r' : ''}.jpg' height=30 class='multimediaicon likeicon' onClick='like(${item['id']})'/>
					<span id='likenr_${item['id']}' class='infonr'>${item['wholikes'].length + (item['liked']?1:0)}</span>
				</div>
				<div class='infospace'>
					<img src='images/watched_icon.png' height=30 class='multimediaicon watchedicon'/>
					<span class='infonr'>0</span>
				</div>
				<div class='infospace'>
					<img src='images/share_icon.png' height=30 class='multimediaicon shareicon'/>
					<span class='infonr'>0</span>
				</div>
			</div>
		</div>
	`;
}
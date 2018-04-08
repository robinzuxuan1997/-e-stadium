var videoScript = {
    type: "mobile_mp4",
    //mobile_3gp,mobile_mp4,pc_mp4,raw,small_3gp,small_mp4
    typemap:{
        "small_mp4":"mp4",
        "mobile_mp4":"mp4",
        "pc_mp4":"mp4",
        "webm":"webm",
        "small_3gp":"3gp",
        "mobile_3gp":"3gp"
            },
    includewebm: false,
    init: function(){
        console.log("video init");
        setTimeout(function(){
            $("#video-close").bind("click touch",
                videoScript.close);   
        },1000);
    },
    videoURL: function(data,type){
        var url=""
        if (data){
            if (!type)
                type=videoScript.type;
            url="/videos/"
					+ data.path
					+ type+"/"
					+ data.filename+"."
					+ videoScript.typemap[type];
        }
        return url;
    },
    thumbnailURL: function(data){
        return this.previewURL(data,'small_mp4');
    },
    previewURL: function(data,type){
        var url=""
        if (data){
            if (!type)
                type=videoScript.type;
            url='/videos/'+
					+ data.path
					+ type+'/'
					+ data.filename
					+ '.jpg';
        }
        return url;
    },
    previewClick: function(event){
        console.log("target: "+event.target);
        var href=event.target.getAttribute("href")||
                 event.target.parentNode.getAttribute("href");
        
        if (videoScript.showVideo(href)){
            event.stopPropagation();
            event.preventDefault();
            return false;
        }
        return true;
    },
    showVideo: function(url){
        if (!url){
            console.log("no url");
            return false;
        }    
        
        //url = url.replace("small_mp4","pc_mp4");
        console.log("show video: "+url);        
        
        var ret = false;
        if (Modernizr.video){
            //ret = this.showHTML5Video(url);
            if (!ret) this.close();
        } 
        if (!ret) {
            var type = this.type;
            //url = url.replace(new RegExp(type),"mobile_3gp").replace(new RegExp("\."+this.typemap[type]),".3gp");
            //url = url.replace("/videos","rtsp://"+location.hostname+":8554/videos");
            
            //rtsp://$this->servername:8554/videos
            
            console.log("no html5 supported: "+url);
            self.location = url;
            /*$("#wrapper").hide();
        
            //Remove the previous video (if it existed)
            $("#video-layer video").remove();
            $("#video-layer object").remove();
            //Make the video layer visible
            var container = $("#video-layer").toggleClass("hidden").get();
            
            $(container).append('<object  width="320" height="288"'+
                'classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"'+
                'codebase="http://www.apple.com/qtactivex/qtplugin.cab">'+
                '<param name="src" value="'+url+'">'+
                '<param name="autoplay" value="true">'+
                '<param name="controller" value="false">'+
                '<embed src="'+url+'" width="320" height="288"'+
                'autoplay="true" controller="false"'+
                'pluginspage="http://www.apple.com/quicktime/download/">'+
                '</embed>'+
                '</object>');// width="160" height="144"
            */
        }
        return ret;
    },
    showHTML5Video: function(url){
        var supported = false;
        //var poster = url.replace(/(\.mp4$)|(\.webm$)|(\.3gp$)/,".jpg");
        var poster = url.replace(/(\.mp4$)|(\.webm$)|(\.3gp$)/,".jpg");
        console.log("poster: "+poster+" for "+url);
        //Hide main website content so it fills the page
        $("#wrapper").hide();
        
        //Remove the previous video (if it existed)
        $("#video-layer video").remove();
        $("#video-layer object").remove();
        //Make the video layer visible
        var container = $("#video-layer").toggleClass("hidden").get();
        
        var vi = document.createElement("video");
        var source1,source2;
        var url2;
        
        if (Modernizr.video.h264 && false){
            source1 = document.createElement("source");
            source1.setAttribute("src",url);
            source1.setAttribute("type",
                    'video/mp4; codecs="avc1.42E01E, mp4a.40.2"');
            vi.appendChild(source1);
            
            console.log("supports mp4: "+url);
            supported=true;
        }
        if (Modernizr.video.h264 && Modernizr.video.webm && this.includewebm){
            
            source2 = document.createElement("source");
            url2 = url.replace(videoScript.type,"webm")
                          .replace("mp4","webm").replace("3gp","webm");
            source2.setAttribute("src",url2);
            source2.setAttribute("type","video/webm; codecs='vp8, vorbis'");
            vi.appendChild(source2);
            
            console.log("supports webm: "+url2);
            supported = true;
        }
        
        if (supported){
            scrollTo(0,0);
            //vi.setAttribute("poster",poster);
            vi.setAttribute("controls","controls");
            vi.setAttribute("autoplay","autoplay");
            vi.setAttribute("preload","auto");
            vi.setAttribute("id","play-video");
            document.getElementById("video-layer").appendChild(vi);        
            
            vi = document.getElementById("play-video");
            vi.addEventListener("load",videoScript.loaded,false);
            vi.addEventListener("ended",videoScript.ended,false);
            document.getElementById("play-video").play();
            
            setTimeout(function(){
                document.getElementById("play-video").play();
            },1000);
        }
        return supported;
    },
    loaded: function(event){
        console.log("video loaded");
        document.getElementById("play-video").play();  
    },
    ended: function(event){
        console.log("video ended"); 
        
        setTimeout(function(){
            videoScript.close();
        },600);
    },
    close: function(event){
        $("#wrapper").show();
        var layer = $("#video-layer");
        $("play-video").remove();
        
        layer.addClass("hidden");
    }
}

document.addEventListener('DOMContentLoaded', videoScript.init, false);
//document.addEventListener("load",videoScript.init,false);
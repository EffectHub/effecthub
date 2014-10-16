//director=cc.Director.getInstance();


var cocos2dApp = cc.Application.extend({
    config:document['ccConfig'],
    ctor:function (scene) {
        this._super();
        this.startScene = scene;
        cc.COCOS2D_DEBUG = this.config['COCOS2D_DEBUG'];
        cc.initDebugSetting();
        cc.setup(this.config['tag']);
        cc.AppController.shareAppController().didFinishLaunchingWithOptions();
    },
    applicationDidFinishLaunching:function () {
        // initialize director
        var director = cc.Director.getInstance();

        cc.EGLView.getInstance()._adjustSizeToBrowser();
        var screenSize = cc.EGLView.getInstance().getFrameSize();

        var searchPaths = [];
        var resDirOrders = [];

        cc.FileUtils.getInstance().setSearchPaths(searchPaths);

        var platform = cc.Application.getInstance().getTargetPlatform();
        resourceSize = cc.size(620, 560);
        designSize = cc.size(620, 560);

        director.setContentScaleFactor(resourceSize.width / designSize.width);
        cc.EGLView.getInstance().setDesignResolutionSize(designSize.width, designSize.height, cc.RESOLUTION_POLICY.SHOW_ALL);
        cc.EGLView.getInstance().resizeWithBrowserSize(false);//important

        //director.setDisplayStats(this.config['showFPS']);
		director.setDisplayStats(true);
        director.setAnimationInterval(1.0 / 60);

        //load resources  (empty)
        cc.LoaderScene.preload([currentTexture ,currentFile/* ,'aaa.png' */ ], 
        	function () {
            	director.replaceScene(new this.startScene());
			}, this);
        return true;
    }
});

var MyLayer = cc.Layer.extend({
    init:function () {

        this._super();
        /*
		var emitter = cc.ParticleFire.create(); // builtin plist
		emitter.setTexture(cc.TextureCache.getInstance().addImage(currentTexture));  // texture
		emitter.setPosition(100,100);
		this.addChild(emitter,10);
		*/
		var emitter2 = cc.ParticleSystem.create(currentFile);  // plist (contains texture PNG)
		emitter2.setPosition(300,300);
		this.addChild(emitter2,10);		
		
	},
});

var MyScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new MyLayer();
        this.addChild(layer);
        layer.init();
    }
});

var myApp = new cocos2dApp(MyScene);



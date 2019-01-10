my.phalcon
admin.phalcon
api.phalcon

app目录构建多模块Home、Admin、Api

	phalcon module --name Home --namespace=App --output=app
	phalcon module --name Admin --namespace=App --output=app
	phalcon module --name Api --namespace=App --output=app

加载各模块的dev、test、pro配置

根据域名加载相应模块
根据开发环境加载配置

common/config/load.php 注册命名空间
common/config/services.php 注册服务

Home/Module.php 
1、注册模块命名空间
2、合并配置、注册服务




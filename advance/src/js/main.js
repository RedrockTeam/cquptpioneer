// import $ from "../../node_modules/zepto/zepto.min.js";
import Fastclick from "../../node_modules/fastclick";

let info = {
    name: '',
    company: 0,
    job: 0
};
const companys = {
    0: '腾讯',
    1: '阿里巴巴',
    2: '百度',
    3: '网易'
};
const jobs = {
    0: '产品实习生',
    1: '运营实习生',
    2: '市场部实习生',
    3: '前端开发实习生',
    4: '后端开发实习生',
    5: '移动开发实习生',
    6: '视觉设计实习生'
};
const images = {
    0: 'public/build/img/tencent.png',
    1: 'public/build/img/alibaba.png',
    2: 'public/build/img/baidu.png',
    3: 'public/build/img/wangyi.png'
};

//表单页
const form = {
    init() {
        this.render();
        this.bind();
        document.querySelector('.button').addEventListener('click', () => {
            if (info.name.replace(/\s/g, '') === '') {
                alert('请输入你的姓名');
                return false;
            };
            location.hash = encodeURIComponent(`?type=result&name=${info.name}&company=${info.company}&job=${info.job}`);
        });
    },
    bind() {
        for (let key in info) {
            let input = document.querySelector(`[name=${key}]`);
            info[key] = input.value;
            input.onchange = function () {
                info[key] = this.value;
                console.log(info);
            };
        };
    },
    render() {
        document.getElementById('form').style.display = 'block';
        document.getElementById('result').style.display = 'none';
        let company = document.createElement('select');
        let job = document.createElement('select');
        for (let key in companys) {
            let opt = document.createElement('option');
            opt.text = companys[key];
            opt.value = key;
            company.appendChild(opt);
        };
        for (let key in jobs) {
            let opt = document.createElement('option');
            opt.text = jobs[key];
            opt.value = key;
            job.appendChild(opt);
        };
        company.name = 'company';
        company.value = info.company;
        job.name = 'job';
        job.value = info.job;
        document.querySelector('.company').replaceChild(company, document.querySelector('[name=company]'));
        document.querySelector('.job').replaceChild(job, document.querySelector('[name=job]'));
    }
};

//展示页
const result = {
    init() {
        for (let key in images) {
            let image = new Image();
            image.src = images[key];
        };
        this.init = function () {
            return false;
        };
    },
    render() {
        document.getElementById('result').style.display = 'block';
        document.getElementById('form').style.display = 'none';        
        let img = new Image();
        img.src = images[info.company];
        img.onload = () => {
            let canvas = document.getElementById('canvas');
            let ctx = canvas.getContext('2d');
            let date = new Date();
            let dateString = `${date.getFullYear()}/${date.getMonth()+1}/${date.getDate()}`;
            ctx.drawImage(img, 0, 0);
            if (info.company == 0) {
                ctx.font = '20px sans-serif';
                ctx.fillStyle = "black";
                ctx.fillText(info.name, 254, 250);
                ctx.fillText(jobs[info.job], 254, 300);
                ctx.fillText(dateString, 254, 347);
            } else if (info.company == 1) {
                ctx.font = '16px sans-serif';
                ctx.fillStyle = "#fd8f35";
                ctx.fillText(info.name, 446, 204);
                ctx.fillText(jobs[info.job], 446, 247);
                ctx.fillText(dateString, 446, 288);
            } else if (info.company == 2) {
                ctx.font = '18px sans-serif';
                ctx.fillStyle = "black";
                ctx.fillText(info.name, 254, 245);
                ctx.fillText(jobs[info.job], 254, 284);
                ctx.fillText(dateString, 254, 324);
            } else if (info.company == 3) {
                ctx.font = '18px sans-serif';
                ctx.fillStyle = "white";
                ctx.fillText(info.name, 254, 298);
                ctx.fillText(jobs[info.job], 254, 328);
                ctx.fillText(dateString, 254, 360);
            } else {
                return false;
            }
            document.getElementById('card').src = canvas.toDataURL("image/png");
        };  
    }
};

//路由
const route = {
    init() {
        this.render.call(this, this.parse()); 
        window.addEventListener('hashchange', () => {
            this.render.call(this, this.parse()); 
        });  
    },
    parse() {
        let hash = decodeURIComponent(location.hash);
        let type = (hash.match(/[\?\&]?type=([^\?\&]+)/) ? hash.match(/[\?\&]?type=([^\?\&]+)/)[1] : 'form') || 'form';
        info.name = (hash.match(/[\?\&]?name=([^\?\&]+)/) ? hash.match(/[\?\&]?name=([^\?\&]+)/)[1] : '') || '';
        info.company = (hash.match(/[\?\&]?company=([^\?\&]+)/) ? hash.match(/[\?\&]?company=([^\?\&]+)/)[1] : 0) || 0;
        info.job = (hash.match(/[\?\&]?job=([^\?\&]+)/) ? hash.match(/[\?\&]?job=([^\?\&]+)/)[1] : 0) || 0;
        return type;
    },
    render(type) {  
        if (!info.name || info.name.replace(/\s/g, '') === '') {
            type = 'form';
        }
        console.log(type);
        switch (type) {
            case 'form':   
                form.init();
                result.init();              
                break;
            case 'result':
                result.init();
                result.render();
                break;
            default:
                break;    
        }
    }
};

window.onload = function () {
    FastClick.attach(document.body);
    route.init();
    console.log('powered by yaosui, https://www.yaosui.me');
};

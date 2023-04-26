# ES Mecury api

## Getting started

Here we are providing following API's for WebApp
- [ ] Menu Links
- [ ] Home Content
- [ ] Products List
- [ ] Solutions List

## Menu Links Response
- URL : {base_url}/api/get/{lang}/menu
- Lang allowed two options (es/en)
- It returns administrable Menu Links from Drupal
- Main is used for Header, Social for Social Link and footer
```
{
    "main": [
        {
            "title": "Solutions",
            "url": "/"
        },
        {
            "title": "Products",
            "url": "/"
        },
        {
            "title": "Innovation",
            "url": "/"
        },
        {
            "title": "Cloud",
            "url": "/"
        },
        {
            "title": "SAAS",
            "url": "/"
        },
        {
            "title": "About Us",
            "url": "/"
        },
        {
            "title": "Blog",
            "url": "/"
        }
    ],
    "social-links": [
        {
            "title": "Linkedin",
            "url": "/"
        },
        {
            "title": "Twitter",
            "url": "/"
        }
    ],
    "footer": [
        {
            "title": "Solutions",
            "url": "/"
        },
        {
            "title": "Products",
            "url": "/"
        },
        {
            "title": "Innovation",
            "url": "/"
        },
        {
            "title": "Saas",
            "url": "/"
        },
        {
            "title": "Cloud",
            "url": "/"
        },
        {
            "title": "About Us",
            "url": "/"
        },
        {
            "title": "News and events",
            "url": "/"
        },
        {
            "title": "Contact",
            "url": "/"
        },
        {
            "title": "Cookies Policy",
            "url": "/"
        },
        {
            "title": "Privacy Policy",
            "url": "/"
        }
    ]
}
```

## Home Content Response
- URL : {base_url}/api/get/{lang}/home
- Lang allowed two options (es/en)
- It returns landing/blog/innovations/cloud/saas content
  administrable from Drupal
```
{
    "banner": {
        "title": "Foreign trade, done",
        "body": "<p><strong>comprehensive solutions</strong><br />\r\nfor your business.</p>\r\n",
        "keywords": [
            "cloud",
            "digital",
            "SaaS"
        ],
        "cta_label": "See how we work"
    },
    "blogs": [
        {
            "title": "Global Shipping: Semiconductors",
            "image": "https://es-mecury.ddev.site/sites/default/files/2022-08/blog.png",
            "cta": "/api/get/en/article/2"
        },
        {
            "title": "Transactionality on several databases",
            "image": "https://es-mecury.ddev.site/sites/default/files/2022-08/blog2.png",
            "cta": "/api/get/en/article/3"
        },
        {
            "title": "II Innovation Forum",
            "image": "https://es-mecury.ddev.site/sites/default/files/2022-08/blog3.png",
            "cta": "/api/get/en/article/4"
        }
    ]
}
```

## Products Content Response
- URL : {base_url}/api/get/{lang}/products/list
- Lang allowed two options (es/en)
- It returns administrable product content from Drupal
```
[
    {
        "title": "Cartas de crédito (Importación)",
        "image": "https://es-mecury.ddev.site/sites/default/files/2022-09/image%20%288%29_0.png",
        "cta": "/api/get/en/product/9"
    },
    {
        "title": "Cartas de crédito (Exportación)",
        "image": "https://es-mecury.ddev.site/sites/default/files/2022-09/image%20%289%29_0.png",
        "cta": "/api/get/en/product/10"
    },
    {
        "title": "Stand-by (Importación)",
        "image": "https://es-mecury.ddev.site/sites/default/files/2022-09/image%20%288%29_1.png",
        "cta": "/api/get/en/product/11"
    },
    {
        "title": "Stand-by (Exportación)",
        "image": "https://es-mecury.ddev.site/sites/default/files/2022-09/image%20%289%29_1.png",
        "cta": "/api/get/en/product/12"
    },
    {
        "title": "Remesas emitidas",
        "image": "https://es-mecury.ddev.site/sites/default/files/2022-09/image%20%288%29_2.png",
        "cta": "/api/get/en/product/13"
    }
]
```

## Solutions Content Response
- URL : {base_url}/api/get/{lang}/solutions/list
- Lang allowed two options (es/en)
- It returns administrable solution content from Drupal
```
[
    {
        "title": "Tradecury Corporate Portal",
        "image": "https://es-mecury.ddev.site/sites/default/files/2022-09/image%20%288%29.png",
        "cta": "/api/get/es/solution/5",
        "category": "Corporate Portal"
    },
    {
        "title": "Tradecury Bank Portal",
        "image": "https://es-mecury.ddev.site/sites/default/files/2022-09/image%20%289%29.png",
        "cta": "/api/get/es/solution/6",
        "category": "Portal Bancario"
    },
    {
        "title": "Middle Office",
        "image": "https://es-mecury.ddev.site/sites/default/files/2022-09/image%20%2810%29.png",
        "cta": "/api/get/es/solution/7",
        "category": "Middle Office"
    },
    {
        "title": "Tradecury Mobile",
        "image": "https://es-mecury.ddev.site/sites/default/files/2022-09/image%20%2811%29.png",
        "cta": "/api/get/es/solution/8",
        "category": "Mobile"
    }
]
```

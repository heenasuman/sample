# ES Mecury Json API

## Getting started

Here we are providing following API's for WebApp
- [ ] Menus
  - Main
  - Social Link
  - Footer
  - Mobile Policies
- [ ] Home
  - Landing
  - Blogs
  - Solutions
  - Products
  - Innovation
- [ ] Newsletter Subscription
- [ ] Contact

## Menus Response (GET)
- URLs:
  - {{base_url}}/{lang}/jsonapi/menu_items/main?sort=weight&fields[menu_link_content--menu_link_content]=title,url&filter[enabled]=true
  - {{base_url}}/{lang}/jsonapi/menu_items/footer?sort=weight&fields[menu_link_content--menu_link_content]=title,url&filter[enabled]=true
  - {{base_url}}/es/jsonapi/menu_items/social-links?sort=weight&fields[menu_link_content--menu_link_content]=title,url,description&filter[enabled]=true
  - {{base_url}}/es/jsonapi/menu_items/policies?sort=weight&fields[menu_link_content--menu_link_content]=title,url&filter[enabled]=true
- Parameters:
  - {lang} : Allowed values es/en
  - {sort} : Sort the results as per weight defined in Drupal
  - {fields} : One can specify required filters to avoid additional information. Here returning Title and URL only.
  - {filter} : One can filter content according to the requirements. Here returning enabled Items only.
- Find Output example given below:
```
{
    "jsonapi": {
        "version": "1.0",
        "meta": {
            "links": {
                "self": {
                    "href": "http://jsonapi.org/format/1.0/"
                }
            }
        }
    },
    "data": [
        {
            "type": "menu_link_content--menu_link_content",
            "id": "menu_link_content:1a731a03-80d9-4432-a4f1-a7356d3876c5",
            "attributes": {
                "title": "Linkedin",
                "url": "/en"
            }
        },
        {
            "type": "menu_link_content--menu_link_content",
            "id": "menu_link_content:352e39b9-1c11-41b7-b5e8-44859c0210fa",
            "attributes": {
                "title": "Twitter",
                "url": "/en"
            }
        }
    ],
    "links": {
        "self": {
            "href": "{{ base_url }}/en/jsonapi/menu_items/social-links?fields%5Bmenu_link_content--menu_link_content%5D=title%2Curl&filter%5Benabled%5D=true&sort=weight"
        }
    }
}
```

## Home Response (GET)
- URLs:
  - {{base_url}}/en/jsonapi/node/landing?filter[status]=1&fields[node--landing]=title,field_keywords,body,field_cta_label,field_show_solutions,field_solutions_tagline,field_show_products,field_products_title,field_products_link,field_show_solutions,field_solutions_title,field_solutions_tagline,field_solutions_link,field_show_innovations,field_innovations_title,field_innovaciones_link,field_blocks,field_newsletter_copy,&include=field_blocks,field_blocks.field_image,field_blocks.field_mobile_image,field_blocks.field_items&fields[paragraph--text_listing_with_image]=field_heading,field_title,field_list,field_image,field_mobile_image&fields[file--file]=uri,url&fields[paragraph--html_list_with_image]=field_heading,field_image,field_mobile_image,field_image_position,field_cta,field_items&fields[paragraph--item]=field_title,field_description,field_counter&fields[paragraph--text]=field_html_title,field_text
  - {{base_url}}/en/jsonapi/node/article?filter[status]=1&include=field_image,field_mobile_image&fields[node--article]=title,field_image,field_mobile_image&fields[file--file]=uri,url
  - {{base_url}}/en/jsonapi/node/solution?filter[status]=1&include=field_image,field_mobile_image,field_category&fields[node--solution]=title,body,field_image,field_mobile_image,field_category&fields[file--file]=uri,url&fields[taxonomy_term--category]=name
  - {{base_url}}/en/jsonapi/node/product?filter[status]=1&include=field_image,field_mobile_image&fields[node--product]=title,body,field_image,field_mobile_image&fields[file--file]=uri,url
  - {{base_url}}/en/jsonapi/node/innovations?filter[status]=1&include=field_image,field_mobile_image&fields[node--innovations]=title,body,field_image,field_mobile_image&fields[file--file]=uri,url
- Parameters:
  - {lang} : Allowed values es/en
  - {filter} : Filtering the Published Content using status = 1
  - {fields} :
    - Landing
      - title (Banner)
      - body (Banner)
      - field_cta_label (Banner)
      - field_keywords (Banner)
      - field_show_solutions (Solutions / To show or hide)
      - field_solutions_title (Solutions)
      - field_solutions_tagline (Solutions)
      - field_solutions_link (Solutions)
      - field_show_products (Products / To show or hide)
      - field_products_title (Products)
      - field_products_link (Products)
      - field_show_innovations (Innovations / To show or hide)
      - field_innovations_title (Innovations)
      - field_innovations_link (Innovations)
      - field_blocks (include content for Cloud & SASS)
        - Text Listing with Image/paragraph--text_listing_with_image (Cloud)
          - field_heading (Section Title)
          - field_title (Section List Title)
          - field_list (Section List Items)
          - field_image (Section Image)
          - field_mobile_image (Section Mobile Image)
        - HTML List with Image/paragraph--html_list_with_image (SaaS)
          - field_heading (Section Title)
          - field_title (Cloud Section List Title)
          - field_image (Section Image)
          - field_mobile_image (Section Mobile Image)
          - field_image_position (Image Position left/right)
          - field_items (with title, description, counter)
          - field_cta (Description Link)
        - Text/paragraph--text (Contact Us)
          - field_html_title
          - field_text
    - Blog
      - title
      - field_image
      - field_mobile_image
    - Solutions
      - title
      - body
      - field_image
      - field_mobile_image
      - field_category
    - Products
      - title
      - body
      - field_image
      - field_mobile_image
```
{
    "jsonapi": {
        "version": "1.0",
        "meta": {
            "links": {
                "self": {
                    "href": "http://jsonapi.org/format/1.0/"
                }
            }
        }
    },
    "data": [
        {
            "type": "node--landing",
            "id": "58a80c4e-5135-4e07-aaa3-ace18f3c8d1e",
            "links": {
                "self": {
                    "href": "{{ base_url }}/es/jsonapi/node/landing/58a80c4e-5135-4e07-aaa3-ace18f3c8d1e?resourceVersion=id%3A1"
                }
            },
            "attributes": {
                "title": "El comercio exterior, hecho",
                "body": {
                    "value": "<p><strong>Soluciones íntegras</strong><br />\r\npara tu negocio.</p>\r\n",
                    "format": "basic_html",
                    "processed": "<p><strong>Soluciones íntegras</strong><br />\npara tu negocio.</p>",
                    "summary": ""
                },
                "field_cta_label": "Mira cómo funcionamos",
                "field_innovations_title": {
                    "value": "Innovaciones <span class=\"clr-7D9624\">Mercury.</span>",
                    "format": "full_html",
                    "processed": "Innovaciones <span class=\"clr-7D9624\">Mercury.</span>"
                },
                "field_keywords": [
                    "cloud",
                    "digital",
                    "SaaS"
                ],
                "field_products_title": "Productos Mercury.",
                "field_show_innovations": true,
                "field_show_products": true,
                "field_show_solutions": true,
                "field_solutions_tagline": "Diseñadas para ofrecer  soluciones automatizadas para el control y la administración total de sus operaciones."
            }
        }
    ],
    "links": {
        "self": {
            "href": "{{ base_url }}/es/jsonapi/node/landing?fields%5Bnode--landing%5D=title%2Cfield_keywords%2Cbody%2Cfield_cta_label%2Cfield_show_solutions%2Cfield_solutions_tagline%2Cfield_show_products%2Cfield_products_title%2Cfield_show_solutions%2Cfield_solutions_tagline%2Cfield_show_innovations%2Cfield_innovations_title&filter%5Bstatus%5D=1"
        }
    }
}
```

## Newsletter Subscription (POST)
- URL : {{base_url}}/en/api/newsletter/subscription
- Parameters:
  - {lang} : Allowed values es/en
  - {fields} :
    - name (string)
    - email (email)
    - tcpp (true/false)
```
{
    "code": 200,
    "message": "Success."
}

{
    "code": 400,
    "message": "Missing parameters."
}

{
    "code": 400,
    "message": "Missing parameter."
}

{
    "code": 400,
    "message": "Invalid email."
}

{
    "code": 400,
    "message": "Only boolean values are allowed."
}

{
    "code": 400,
    "message": "Record already exists."
}
```


## Contact

## Consultation Types (Post)
- URL : {{base_url}}/es/jsonapi/taxonomy_term/consultation?fields[taxonomy_term--consultation]=drupal_internal__tid,name&sort=weight
- Parameters:
  - {lang} : Allowed values es/en
  - {sort} : Sort records by weight set in the Drupal
  - {fields} :
    - drupal_internal__tid (Will be used to send Contact Request)
    - name
- Response
```
{
    "jsonapi": {
        "version": "1.0",
        "meta": {
            "links": {
                "self": {
                    "href": "http://jsonapi.org/format/1.0/"
                }
            }
        }
    },
    "data": [
        {
            "type": "taxonomy_term--consultation",
            "id": "2eb23efd-60a3-4fa1-a9e3-d6ceaee8e360",
            "links": {
                "self": {
                    "href": "{{ base_url }}/es/jsonapi/taxonomy_term/consultation/2eb23efd-60a3-4fa1-a9e3-d6ceaee8e360?resourceVersion=id%3A5"
                }
            },
            "attributes": {
                "drupal_internal__tid": 5,
                "name": "Solicitar una demo"
            }
        },
        {
            "type": "taxonomy_term--consultation",
            "id": "03a04c1f-f679-4df6-990c-5c955af76038",
            "links": {
                "self": {
                    "href": "{{ base_url }}/es/jsonapi/taxonomy_term/consultation/03a04c1f-f679-4df6-990c-5c955af76038?resourceVersion=id%3A6"
                }
            },
            "attributes": {
                "drupal_internal__tid": 6,
                "name": "Oferta de trabajo"
            }
        },
        {
            "type": "taxonomy_term--consultation",
            "id": "faa40be9-aa1a-4e3f-a2fa-d8302f61ca63",
            "links": {
                "self": {
                    "href": "{{ base_url }}/es/jsonapi/taxonomy_term/consultation/faa40be9-aa1a-4e3f-a2fa-d8302f61ca63?resourceVersion=id%3A7"
                }
            },
            "attributes": {
                "drupal_internal__tid": 7,
                "name": "Marketing"
            }
        },
        {
            "type": "taxonomy_term--consultation",
            "id": "f642029f-9bc3-4070-8b2a-46fd2c491728",
            "links": {
                "self": {
                    "href": "{{ base_url }}/es/jsonapi/taxonomy_term/consultation/f642029f-9bc3-4070-8b2a-46fd2c491728?resourceVersion=id%3A8"
                }
            },
            "attributes": {
                "drupal_internal__tid": 8,
                "name": "¿Quieres ser partner?"
            }
        },
        {
            "type": "taxonomy_term--consultation",
            "id": "ccfdacca-3f0f-47dc-9e3f-095913f9d745",
            "links": {
                "self": {
                    "href": "{{ base_url }}/es/jsonapi/taxonomy_term/consultation/ccfdacca-3f0f-47dc-9e3f-095913f9d745?resourceVersion=id%3A9"
                }
            },
            "attributes": {
                "drupal_internal__tid": 9,
                "name": "Otros"
            }
        }
    ],
    "links": {
        "self": {
            "href": "{{ base_url }}/jsonapi/taxonomy_term/consultation?fields%5Btaxonomy_term--consultation%5D=drupal_internal__tid%2Cname&sort=weight"
        }
    }
}
```
## Upload CV File (Post)
- URL: {{base_url}}/file/upload/media/cv/field_media_document?_format=json
- Parameters: Upload File
- Response
```
{
    "fid": [
        {
            "value": 32
        }
    ],
    "uuid": [
        {
            "value": "caf1cd2b-80db-45ae-a6be-9175a83cdb94"
        }
    ],
    "langcode": [
        {
            "value": "es"
        }
    ],
    "uid": [
        {
            "target_id": 1,
            "target_type": "user",
            "target_uuid": "a64f94cd-bf94-4a1c-9996-bf0d8a8df431",
            "url": "/es/user/1"
        }
    ],
    "filename": [
        {
            "value": "sample.txt"
        }
    ],
    "uri": [
        {
            "value": "public://2022-09/sample_0.txt",
            "url": "/sites/default/files/2022-09/sample_0.txt"
        }
    ],
    "filemime": [
        {
            "value": "text/plain"
        }
    ],
    "filesize": [
        {
            "value": 4423
        }
    ],
    "status": [
        {
            "value": false
        }
    ],
    "created": [
        {
            "value": "2022-09-06T17:25:15+00:00",
            "format": "Y-m-d\\TH:i:sP"
        }
    ],
    "changed": [
        {
            "value": "2022-09-06T17:25:15+00:00",
            "format": "Y-m-d\\TH:i:sP"
        }
    ]
}
```

## Submit Contact Request (Post)
- URL: {{base_url}}/es/webform_rest/submit
- Parameters: Given Below
```
{
  "webform_id": "contact",
  "name": "Developer test",
  "email": "developer@gmail.com",
  "telephone": "+324394329",
  "type": 8 (Get from Consultation Types request Response),
  "message": "Lorem Ipsum",
  "linkedin": {"url": "https://www.linkedin.com/"},
  "cv": 31 (Get fid from Upload CV request Response),
  "tcpp": 1
}
```
- Response
```
{
  "sid": "f593622b-9fc9-433a-b7ee-bf196535089e"
}
```

## Cookie Policy
- URL: {{base_url}}/api/get/es/general
- Parameters:
  - {lang} : Allowed values es/en
  - Response
```
{
    "cookie_policy": {
        "body": "<h2>Tu privacidad es importante.</h2>\r\n<p>Utilizamos cookies para asegurar que damos la mejor experiencia al usuario en nuestro sitio web. Si continúa utilizando este sitio asumiremos que está de acuerdo.</p>",
        "button": "Aceptar",
        "link": {
            "label": "Ver política de cookies",
            "url": "https://es-mecury.ddev.site/es/privacy"
        }
    }
}
```

## Blog Page
- Listing URL: {{base_url}}/en/jsonapi/node/article?filter[status]=1&include=field_image,field_mobile_image,field_tags&fields[node--article]=title,path,field_image,field_mobile_image,field_tags,field_publication_date&fields[file--file]=uri,url&fields[taxonomy_term--tags]=name
- URL: {{base_url}}/es/jsonapi/node/article/{id}?filter[status]=1&include=field_image,field_mobile_image,field_tags,field_related_articles&fields[node--article]=title,body,field_image,field_mobile_image,field_tags,field_author,field_publication_date,field_related_articles,path&fields[file--file]=uri,url&fields[taxonomy_term--tags]=name
- Parameters:
  - {lang} : Allowed values es/en
  - {id} :  Unique Identifier of the node, that can be got from Listing Url
  - {fields} :
    - path
    - title
    - body
    - field_image
    - field_mobile_image
    - field_tags
    - field_author
    - field_publication_date
    - field_related_articles

## Solution Page
- Listing URL: {{base_url}}/en/jsonapi/node/solution?filter[status]=1&include=field_image,field_mobile_image,field_side_image,field_category&fields[node--solution]=title,path,body,field_image,field_mobile_image,field_side_image,field_category&fields[file--file]=uri,url&fields[taxonomy_term--category]=name
- URL: {{base_url}}/es/jsonapi/node/solution/{id}?filter[status]=1&include=field_image,field_mobile_image,field_blocks.field_items,field_blocks.field_items.field_image&fields[node--solution]=title,body,field_html_title,field_image,field_mobile_image,field_side_image,field_blocks&fields[file--file]=uri,url&fields[paragraph--lists_and_icon_grids]=field_title,field_plain_list,field_list,field_items&fields[paragraph--icon_text]=field_description,field_image
- Parameters:
  - {lang} : Allowed values es/en
  - {id} :  Unique Identifier of the node, that can be got from Listing Url
  - {fields} :
    - path
    - title
    - body
    - field_html_title
    - field_image
    - field_mobile_image
    - field_side_image (Used on Solutions Listing Page)
    - field_category
    - field_blocks
      - {paragraph--lists_and_icon_grids}
        - field_title
        - field_plain_list
        - field_list
        - field_items
          - {paragraph--icon_text} (Icon Card)
            - field_description
            - field_image

## Innovation Page
- Listing URL: {{base_url}}/en/jsonapi/node/innovations?filter[status]=1&include=field_image,field_mobile_image&fields[node--innovations]=title,path,field_image,field_catalog_heading,field_catalog_listing&fields[file--file]=uri,url
- URL: {{base_url}}/es/jsonapi/node/innovations/{id}?filter[status]=1&include=field_image,field_mobile_image,field_blocks.field_items,field_blocks.field_items.field_image&fields[node--innovations]=title,path,body,field_html_title,field_image,field_mobile_image,field_features,field_blocks&fields[file--file]=uri,url&fields[paragraph--lists_and_icon_grids]=field_title,field_plain_list,field_list,field_items&fields[paragraph--icon_text]=field_description,field_image
- ESG URL : {{base_url}}/es/jsonapi/node/innovations/e755b18e-fd15-47f2-aee1-a6c95537f798?filter[status]=1&include=field_image,field_mobile_image,field_blocks.field_image,field_blocks.field_service,field_blocks.field_service.field_image&fields[node--innovations]=field_html_title,field_image,field_mobile_image,field_features,field_blocks&fields[file--file]=uri,url&fields[paragraph--services]=field_service&fields[paragraph--service]=field_title,field_description&fields[paragraph--service_impacts]=field_title,field_image,field_service&fields[paragraph--service_forms]=field_title,field_description,field_impacts,field_image
- Parameters:
  - {lang} : Allowed values es/en
  - {id} :  Unique Identifier of the node, that can be got from Listing Url
  - {fields} : Catalog Page
    - title
    - path
    - field_image
    - field_catalog_heading
    - field_catalog_listing
  - {fields} : Inner Page
    - field_html_title
    - field_image
    - field_mobile_image
    - field_blocks
      - {paragraph--lists_and_icon_grids}
        - field_title
        - field_plain_list
        - field_list
        - field_items
          - {paragraph--icon_text} (Icon Card)
            - field_description
            - field_image
  - {fields} : ESG Page
    - field_html_title
    - field_image
    - field_mobile_image
    - field_blocks
      - {paragraph--services}
        - field_service
          - {paragraph--service}
            - field_title
            - field_description
      - {paragraph--service_impacts}
        - field_service
          - {paragraph--service_forms}
            - field_title
            - field_description
            - field_impacts
            - field_image

## Product Page
- Listing URL: {{base_url}}/es/jsonapi/node/product?filter[status]=1&include=field_image,field_mobile_image&fields[node--product]=title,field_image,field_mobile_image,field_introduction_description,field_checklist&fields[file--file]=uri,url
- URL: {{base_url}}/es/jsonapi/node/product/{id}?filter[status]=1&include=field_image,field_mobile_image,field_blocks.field_items,field_blocks.field_items.field_image,field_blocks.field_image,field_blocks.field_mobile_image&fields[node--product]=title,path,field_image,field_mobile_image,field_blocks&fields[file--file]=uri,url&fields[paragraph--lists_and_icon_grids]=field_title,field_plain_list,field_list,field_items&fields[paragraph--icon_text]=field_description,field_image&fields[paragraph--module]=field_title,field_desc,field_list,field_image,field_mobile_image
- URL(Module Page): {{base_url}}/es/jsonapi/node/product/bf60383b-88f7-491e-b3ff-a34ae86b46aa?filter[status]=1&include=field_image,field_mobile_image,field_blocks.field_items,field_blocks.field_items.field_image,field_blocks.field_image,field_blocks.field_mobile_image&fields[node--product]=title,field_image,field_mobile_image,field_blocks&fields[file--file]=uri,url&fields[paragraph--lists_and_icon_grids]=field_title,field_plain_list,field_list,field_items&fields[paragraph--icon_text]=field_description,field_image&fields[paragraph--module]=field_title,field_desc,field_list,field_image,field_mobile_image
- Parameters:
  - {lang} : Allowed values es/en
  - {id} :  Unique Identifier of the node, that can be got from Listing Url
  - {fields} :
    - path
    - title
    - field_image
    - field_mobile_image
    - field_blocks
      - {paragraph--lists_and_icon_grids}
        - field_title
        - field_plain_list
        - field_list
        - field_items
          - {paragraph--icon_text} (Icon Card)
            - field_description
            - field_image
      - {paragraph--module}
        - field_title
        - field_desc
        - field_list
        - field_image
        - field_mobile_image

## Trabaja con nosotros
- URL: {{base_url}}/es/jsonapi/node/page?filter[status]=1&filter[field_page_id]=trabaja_con_nosotros&fields[node--page]=field_html_title,field_headline,body,field_image,field_cta&include=field_image&fields[file--file]=uri,url
- Parameters:
  - {lang} : Allowed values es/en
  - {fields} :
    - field_html_title
    - field_headline
    - field_image
    - body
    - field_cta

## Valores mercurianos
- URL: {{base_url}}/es/jsonapi/node/page?filter[status]=1&filter[field_page_id]=valores_mercurianos&fields[node--page]=field_html_title,field_headline,body,field_blocks&include=field_blocks.field_members,field_blocks.field_members.field_image,field_blocks.field_items,field_blocks.field_items.field_image,field_blocks.field_properties,field_blocks.field_service&fields[file--file]=uri,url&fields[paragraph--about_us]=field_properties&fields[paragraph--property]=field_title,field_description&fields[paragraph--team]=field_html_title,field_members&fields[paragraph--member]=field_name,field_designation,field_image,field_linkedin_profile&fields[paragraph--culture]=field_html_title,field_description,field_items&fields[paragraph--icon_text]=field_description,field_image&fields[paragraph--what_we_do]=field_service&fields[paragraph--service]=field_title,field_description
- Parameters:
  - {lang} : Allowed values es/en
  - {fields} :
    - field_html_title
    - field_headline
    - body
    - field_blocks
      - {paragraph--about_us}
        - field_properties
          - {paragraph--property}
            - field_title
            - field_description
      - {paragraph--team}
        - field_title
        - field_members
          - {paragraph--member}
            - field_name
            - field_designation
            - field_image
      - {paragraph--culture}
        - field_html_title
        - field_description
        - field_items
          - {paragraph--icon_text}
            - field_description
            - field_image

##Partners
-URL: {{base_url}}/es/jsonapi/taxonomy_term/partners?sort=weight&fields[taxonomy_term--partners]=drupal_internal__tid,field_logo,field_url&fields[file--file]=uri,url&include=field_logo

##SAAS
-URL: {{base_url}}/es/jsonapi/node/page?filter[status]=1&filter[field_page_id]=saas&include=field_image,field_mobile_image,field_blocks.field_items,field_blocks.field_items.field_image,field_blocks.field_checklist,field_blocks.field_checklist.field_image&fields[node--page]=field_html_title,field_headline,body,field_image,field_mobile_image,field_blocks&fields[file--file]=uri,url&fields[paragraph--lists_and_icon_grids]=field_items&fields[paragraph--icon_text]=field_title,field_description,field_image&fields[paragraph--security]=field_title,field_description,field_checklist&fields[paragraph--item]=field_title,field_description

##CLOUD
-URL: {{base_url}}/es/jsonapi/node/page?filter[field_page_id]=cloud&filter[status]=1&include=field_image,field_mobile_image,field_blocks.field_items,field_blocks.field_items.field_image&fields[node--page]=field_html_title,field_image,field_mobile_image,field_blocks,field_features&fields[file--file]=uri,url&fields[paragraph--lists_and_icon_grids]=field_items,field_list,field_title&fields[paragraph--icon_text]=field_description,field_image

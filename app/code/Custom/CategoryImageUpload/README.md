# Magento 2 module

#### Purpose ####

Добавить дополнительный атрибут на категорию типа изображения (Image). Реализовать его сохранение и вывод в футере на странице категории при наличии.

Add an extra attribute to the image type category (Image). Implement its saving and output in the footer on the category page if available.

#### Solution ####

1. Create an upgrade data script to create the new category image attribute.
app/code/Custom/CategoryImageUpload/Setup/InstallData.php


2. Create new upload class for the new image attribute.
app/code/Custom/CategoryImageUpload/Controller/Adminhtml/Category/CustomImage/Upload.php

```php
$result = $this->imageUploader->saveFileToTmpDir('{image-attribute-code}');
```


3. Add the new fields to the admin html category form.
app/code/Custom/CategoryImageUpload/view/adminhtml/ui_component/category_form.xml

```xml
<field name="{image-attribute-code}">
<item name="label" xsi:type="string" translate="true">{Image Label}</item>
<item name="url" xsi:type="url" path="categoryimage/category_customimage/{upload-class-file-name}"/>
```


4. Add the new image attribute code to the helper class
app/code/Custom/CategoryImageUpload/Helper/Data.php


You can to see the new field on the category screen under the **Content** group. 
You can also to upload, save and delete the image file successfully. 


6. Show the new image on frontend footer.
The above block can print category images ONLY on category pages cause it assumes there is already stored category model in core registry.
app/code/Custom/CategoryImageUpload/view/frontend/layout/catalog_category_view.xml

```php
<argument name="image_code" xsi:type="string">{image-attribute-code}</argument>
<argument name="css_class" xsi:type="string">{div-css-class}</argument>
```

app/code/Custom/CategoryImageUpload/view/frontend/templates/image.phtml
app/code/Custom/CategoryImageUpload/Block/Image.php


7. If you need to print the image on other pages use the following code snippet.
```PHP
$category = 'load a category model class here'; // the decision how to load category model object is up to you.
$helper    = $this->helper('SR\CategoryImage\Helper\Category');
$imageUrl = $helper->getImageUrl($category->getData('image-attribute-code'));
```
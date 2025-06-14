-- =====================================================
-- Object:  Table [dbo].[archivos]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[archivos] (
	[id] [int] IDENTITY(1,1) NOT NULL PRIMARY KEY,
    [nombre] [nvarchar](255) NOT NULL,
    [ruta] [nvarchar](255) NOT NULL,
    [tamaño] [int] NOT NULL,
    [fecha_modificacion] [datetime] NULL DEFAULT GETDATE(),
    [carpeta_id] [int] NULL,
    
    CONSTRAINT FK_Archivos_Carpetas FOREIGN KEY (carpeta_id)
		REFERENCES [dbo].[carpetas] (id)
		ON DELETE SET NULL
);